<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;


class UserController extends Controller
{   public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('username', $validated['username'])->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Incorrect password.'], 401);
        }
    
        if (!$user->verified) {
            return response()->json(['message' => 'Your email is not verified. Please verify your email to log in.'], 403);
        }
        
        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,   
        ], 200);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|min:6',
            'verified' => 'sometimes|boolean',
            'profileImage' => 'sometimes|string',
        ]);

        $existingUser = User::where('username', $validated['username'])->orWhere('email', $validated['email'])->first();

        if ($existingUser) {
            return response()->json([
                'message' => 'Username or email already exists.',
            ], 409);
        }

        $verifiedStatus = $validated['verified'] ?? false;
        $hashedPassword = Hash::make($validated['password']);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
            'verified' => $verifiedStatus,
            'profileImage' => 'www.sampleprofile.com'
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->_id]
        );

        $user->notify(new VerifyEmail($verificationUrl));

        return response()->json([
            'message' => 'User added successfully. A verification email has been sent.',
            'user_id' => $user->_id,
        ], 201);
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'No user found with this email address.'], 404);
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetUrl = url("https://extrcust.vercel.app/resetPassword/{$token}/{$validated['email']}");

        Mail::raw("Click this link to reset your password: {$resetUrl}", function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset Request');
        });
        
        return response()->json(['message' => 'Check your email to change your password'], 200);
    }
    
    public function resetPassword(Request $request, $token)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetRecord = DB::table('password_resets')
                        ->where('email', $validated['email'])
                        ->first();

        if (!$resetRecord) {
            return response()->json(['message' => 'Invalid token or email.'], 400);
        }

        if (!Hash::check($token, $resetRecord->token)) {
            return response()->json(['message' => 'Invalid token.'], 400);
        }

        // Update user password
        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            $user->password = Hash::make($validated['password']);
            $user->save();

            // Delete reset record
            DB::table('password_resets')->where('email', $validated['email'])->delete();

            return response()->json(['message' => 'Password reset successfully.'], 200);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }


    public function verifyEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->verified) {
            return redirect()->to('https://extrcust.vercel.app/verifyStatus/failed');
        }

        $user->verified = true;
        $user->save();

        return redirect()->to('https://extrcust.vercel.app/verifyStatus/success');
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username',
            'email' => 'sometimes|email|unique:users,email,',
            'password' => 'sometimes|string|min:6|confirmed',
            'verified' => 'sometimes|boolean',
            'profileImage' => 'sometimes|file|image|max:2048',
        ]);

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($request->hasFile('profileImage')) {
            $cloudinary = new Cloudinary(config('cloudinary.url'));

            if ($user->profileImage) {
                $publicId = pathinfo($user->profileImage, PATHINFO_FILENAME);
                $cloudinary->uploadApi()->destroy($publicId);
            }

            $uploadedFileUrl = $cloudinary->uploadApi()->upload(
                $request->file('profileImage')->getRealPath(),
                [
                    'folder' => 'profile-images',
                    'public_id' => $user->id,
                    'overwrite' => true,
                    'resource_type' => 'image',
                ]
            )['secure_url'];

            $validated['profileImage'] = $uploadedFileUrl;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if (!empty($validated['email']) && $validated['email'] !== $user->email) {
            $validated['verified'] = false;

            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id]
            );

            $user->notify(new VerifyEmail($verificationUrl));
        }

        $user->fill($validated);
        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user,
            'profileImageUrl' => $user->profileImage,
        ], 201);
    }
}
