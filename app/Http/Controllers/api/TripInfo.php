<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;

class TripInfo extends Controller
{
    public function getTripById($id)
    {
        $trip = Trip::with('repeatTrip')->where('id', $id)->get();

        $driverId=Trip::where('id',$id)->value('driver_id');
        $userId=Driver::where('id',$driverId)->value('user_id');

        $drivers = User::where('id', $userId)
            ->first();
        $car = Car::where('driver_id', $driverId)
            ->first();


        if (!$trip) {
            return response()->json([
                'message' => 'Trip not found'
            ], 404);
        }
        return response()->json([
            'Trip' => $trip,
            'Drivers' => $drivers,
            'Cars' => $car,

        ]);

    }
}
