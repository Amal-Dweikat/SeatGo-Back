<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function updateStatus($id, Request $request)
{
    $request->validate([
        'status' => 'required|in:approved,rejected'
    ]);

    $booking = Booking::with('trip')->findOrFail($id);
    $trip = $booking->trip;

    $bookedSeats = Booking::where('trip_id', $trip->id)
        ->where('status', 'approved')
        ->where('id', '!=', $booking->id) 
        ->sum('numSeatBooked');

    if ($request->status === 'approved') {

        $newTotal = $bookedSeats + $booking->numSeatBooked;

        if ($newTotal > $trip->TotalSeats) {
            return response()->json([
                'message' => 'Not enough seats available'
            ], 422);
        }

        $booking->accepted_at = now();
    }

    if ($request->status === 'rejected') {
        $booking->accepted_at = null;
    }

    $booking->status = $request->status;

    $booking->save();

    return response()->json([
        'message' => 'Status updated successfully',
        'booking' => $booking->load('user')
    ]);
}
}