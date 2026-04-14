<?php

namespace App\Http\Controllers\api;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingTrip
{
    public function Booking(Request $request)
    {
        $booking = Booking::create([
            'trip_id' => $request->trip_id,
            'user_id' => auth()->id(),
            'numSeatBooked' => $request->numSeatBooked,
            'UserWantRepeat' => $request->UserWantRepeat ?? false,
            'EndRepeat' => $request->EndRepeat ?? null,
            'UserSelectedDays' => $request->UserSelectedDays ?? null,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }


}
