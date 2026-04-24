<?php

namespace App\Http\Controllers;

use App\Models\Trip;

class TripController extends Controller
{
    public function show($id)
{
    $trip = Trip::with(['bookings.user'])->find($id);

    if (!$trip) {
        return response()->json(['message' => 'Trip not found'], 404);
    }

    $acceptedCount = $trip->bookings
        ->where('status', 'accepted')
        ->count();

    $availableSeats = $trip->TotalSeats - $acceptedCount;

    return response()->json([
        'trip' => [
            ...$trip->toArray(),
            'available_seats' => $availableSeats, 
        ],
        'pending' => $trip->bookings->where('status', 'pending')->values(),
        'accepted' => $trip->bookings->where('status', 'accepted')->values(),
    ]);
}

    public function destroy($id)
{
    $trip = Trip::find($id);

    if (!$trip) {
        return response()->json(['message' => 'Trip not found'], 404);
    }

    $trip->delete();

    return response()->json(['message' => 'Trip deleted successfully']);
}
}