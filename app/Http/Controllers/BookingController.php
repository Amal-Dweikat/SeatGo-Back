<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function accept($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    $booking->status = 'accepted';
    $booking->accepted_at = now(); 
    $booking->save();

    return response()->json([
        'message' => 'Accepted successfully',
        'booking' => $booking
    ]);
}
    public function reject($id)
    {
        $booking = Booking::with('trip')->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $trip = $booking->trip;

        if ($booking->status === 'accepted' && $trip) {
            $trip->TotalSeats += 1;
            $trip->save();
        }

        $booking->status = 'rejected';
        $booking->save();

        return response()->json(['message' => 'Booking rejected']);
    }
}