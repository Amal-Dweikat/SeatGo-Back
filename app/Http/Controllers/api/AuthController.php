<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Mail;
use App\Models\FavoriteDriver;
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
        auth()->invalidate(true);

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

public function favoriteDrivers()
{
    $userId = auth()->id();

    $favorites = \DB::table('favorite_drivers')
        ->join('users', 'favorite_drivers.driver_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.full_name',
            'users.email',
            'users.profile_picture',
            'users.average_rating'
        )
        ->where('favorite_drivers.user_id', $userId)
        ->get();

    return response()->json($favorites);
}
public function removeFavoriteDriver($driverId)
{
    FavoriteDriver::where('user_id', auth()->id())
        ->where('driver_id', $driverId)
        ->delete();

    return response()->json([
        'message' => 'Removed successfully'
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
