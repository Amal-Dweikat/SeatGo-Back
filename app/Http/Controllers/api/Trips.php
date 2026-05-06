<?php

namespace App\Http\Controllers\api;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\RepeatTrip;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Trips
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
    public function Schedule(Request $request)
    {


$driverId=Driver::where('user_id',auth()->id())->value('id');
        $schedule1 = Trip::create([
            'driver_id'=>$driverId,
            'FromCity' => $request->FromCity,
            'ToCity' => $request->ToCity ,
            'FromRegion' => $request->SpecificFromArea,
            'ToRegion' => $request->SpecificToArea,
            'Price' => $request->price,
            'TotalSeats' => $request->setas,
            'BookedSeats' => 0,
            'DepartureTime' => $request->time,
            'ArrivalTime' => Carbon::parse($request->time)->addHours(2),
            'DateTrip' => $request->date,
            'note' => $request->note,
            'transport' => $request->transport,
            'RepliedAdmin' => true,
            'status' => "approved",
            'TripRepeat' => $request->DriverWantRepeat,
        ]);
        if($request->DriverWantRepeat) {
            $schedule2 = RepeatTrip::create([
                'trip_id' => $schedule1->id,
                'EndRepeat' => $request->EndRepeat,
                'DriverSelectedDays' => $request->DriverSelectedDays,
            ]);
        }

        return response()->json([
            'message' => 'Trip schedule successfully',
        ], 201);
    }
    public function GetTrip(){

        $user = auth()->user();


        if ($user->role === 'driver') {

            $driverId = Driver::where('user_id', $user->id)->value('id');

            $trips = Trip::with('repeatTrip')->where('driver_id', $driverId)->get();
        }

        else {


             $trips = Booking::where('user_id', $user->id)->with('trip')->get();
        }

        return response()->json([
            'Trip' => $trips,

        ]);

    }

}
