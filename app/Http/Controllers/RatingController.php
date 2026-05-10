<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Trip;
use App\Models\FavoriteDriver;
use App\Models\User;
class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required',
            'rated_user_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Rating::create([
            'trip_id' => $request->trip_id,
            'rater_user_id' => auth()->id(),
            'rated_user_id' => $request->rated_user_id,
            'rating' => $request->rating,
        ]);
        $average = Rating::where('rated_user_id', $request->rated_user_id)
            ->avg('rating');

        $user = User::find($request->rated_user_id);

        $user->average_rating = round($average, 1);

        $user->save();
        return response()->json(['message' => 'Rated successfully']);
    }
    public function finishedTrip()
    {
        $user = auth()->user();

        $trip = Trip::where('status', 'completed')
            ->whereHas('bookings', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->first();

        if (!$trip) {
            return response()->json(null);
        }

        $alreadyRated = Rating::where('trip_id', $trip->id)
            ->where('rater_user_id', $user->id)
            ->where('rated_user_id', $trip->driver->user->id)
            ->exists();

        if ($alreadyRated) {
            return response()->json(null);
        }

        return response()->json([
            'trip' => $trip,
            'driver' => $trip->driver->user,
            'passengers' => $trip->bookings->load('user'),
        ]);
    }

    public function addFavorite(Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
        ]);

        FavoriteDriver::create([
            'user_id' => auth()->id(),
            'driver_id' => $request->driver_id,
        ]);

        return response()->json([
            'message' => 'Added to favorites'
        ]);
    }
}
