<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Booking;

class TripController extends Controller
{
    public function show($id)
{
    $trip = Trip::with(['bookings.user'])->find($id);

if (!$trip) {
    return response()->json([
        'message' => 'Trip not found'
    ], 404);
}

$approvedBookings = $trip->bookings->where('status', 'approved');

$bookedSeats = $approvedBookings->sum('numSeatBooked');

return response()->json([
    'trip' => [
        ...$trip->toArray(),
        'BookedSeats' => $bookedSeats,
        'available_seats' => $trip->TotalSeats - $bookedSeats,
    ],

    'pending' => $trip->bookings
        ->where('status', 'pending')
        ->values()
        ->map(function ($b) {
            return [
                'id' => $b->id,
                'numSeatBooked' => $b->numSeatBooked,
                'user' => [
                    'full_name' => $b->user->full_name,
                ],
            ];
        }),

    'accepted' => $approvedBookings
        ->values()
        ->map(function ($b) {
            return [
                'id' => $b->id,
                'numSeatBooked' => $b->numSeatBooked,
                'accepted_at' => $b->accepted_at,
                'user' => [
                    'full_name' => $b->user->full_name,
                ],
            ];
        }),
]);
}

public function update(Request $request, $id)
{
    try {
        $trip = Trip::findOrFail($id);

        $trip->update($request->all());

        return response()->json([
            'message' => 'Updated successfully',
            'trip' => $trip
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function destroy($id)
{
    $trip = Trip::with('bookings.notifications')->find($id);

    if (!$trip) {
        return response()->json(['message' => 'Trip not found'], 404);
    }

    foreach ($trip->bookings as $booking) {
        $booking->notifications()->delete();
    }

    $trip->bookings()->delete();
    $trip->delete();

    return response()->json(['message' => 'Trip deleted successfully']);
}
}