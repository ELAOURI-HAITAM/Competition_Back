<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{


    public function index()
    {
        $user = User::all();
        return response()->json(['users' => $user], 200);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ]);
    }


    
}
