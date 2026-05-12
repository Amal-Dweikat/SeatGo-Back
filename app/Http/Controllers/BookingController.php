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

        $booking = Booking::with('user')->findOrFail($id);

        $booking->status = $request->status;

        if ($request->status === 'approved') {
            $booking->accepted_at = now();
        }

        $booking->save();

        $title = $request->status === 'approved'
            ? 'Booking Accepted ✅'
            : 'Booking Rejected ❌';

        $body = $request->status === 'approved'
            ? 'Your booking was accepted'
            : 'Your booking was rejected';

        Notification::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'title' => $title,
            'body' => $body,
            'type' => 'booking_' . $request->status,
        ]);

        return response()->json([
            'message' => 'Status updated successfully',
            'booking' => $booking
        ]);
    }
}