<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{   
    public function getUsers()
    {
        $users = DB::connection('mongodb')->table('users')->get();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $hashedPassword = Hash::make($validated['password']);

        $userId = DB::connection('mongodb')->table('users')->insertGetId([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
        ]);

        return response()->json([
            'message' => 'User added successfully',
            'user_id' => $userId,
        ], 201);
    }
}
