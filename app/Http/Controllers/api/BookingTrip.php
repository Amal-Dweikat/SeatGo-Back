<?php

namespace App\Http\Controllers\api;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;

class BookingTrip
{
    public function Booking(Request $request)
    {



        $booking = Booking::create([
            'trip_id' => $request->Trip_id ?? 1,
            'user_id' => auth()->id() ,
            'numSeatBooked' => $request->NumSeat,
            'UserWantRepeat' => $request->WantRepeat ?? false,
            'EndRepeat' => $request->dateOfEndRepeat ?? null,
            'UserSelectedDays' => $request->SelectedDays ?? null,
        ]);

        $trip = Trip::find($request->Trip_id);
        $trip->BookedSeats += $request->NumSeat;
        $trip->save();

        return response()->json([
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }


}
