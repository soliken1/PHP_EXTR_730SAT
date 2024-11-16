<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;


class UserController extends Controller
{   public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }    

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'verified' => 'sometimes|boolean',
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

    public function verifyEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->verified) {
            return response()->json(['message' => 'User already verified.'], 200);
        }

        $user->verified = true;
        $user->save();

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }
}
