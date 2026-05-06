<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone_number' => 'required|unique:users',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'passenger',
        ]);


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }




    public function login(Request $request)
    {
        $user = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($user)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => auth()->user()
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($request->full_name)
            $user->full_name = $request->full_name;

        if ($request->email)
            $user->email = $request->email;

        if ($request->phone_number)
            $user->phone_number = $request->phone_number;

        $user->save();

        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 400);
        }


        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
    public function updateImage(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_picture' => 'required|string'
        ]);

        $user->profile_picture = $request->profile_picture;
        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }

}
