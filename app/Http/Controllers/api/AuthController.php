<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone_number' => 'required',
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

    public function forgotPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'message' => 'USER NOT FOUND'
        ], 404);
    }

    $code = rand(100000, 999999);

    $user->reset_code = $code;
    $user->save();

    Mail::raw("Your reset code is: $code", function ($message) use ($user) {
        $message->to($user->email)
            ->subject('Password Reset Code');
    });

    return response()->json([
        'message' => 'SENT'
    ]);
}


public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'USER_NOT_FOUND'], 404);
    }

    if ((string)$user->reset_code !== (string)$request->code) {
        return response()->json(['message' => 'INVALID_CODE'], 400);
    }

    return response()->json(['message' => 'VERIFIED']);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required',
        'password' => 'required|min:6'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'USER NOT FOUND'], 404);
    }

    if ((string)$user->reset_code !== (string)$request->code) {
        return response()->json(['message' => 'INVALID_CODE'], 400);
    }

    $user->password = bcrypt($request->password);
    $user->reset_code = null;
    $user->save();

    return response()->json(['message' => 'SUCCESS']);
}
}
