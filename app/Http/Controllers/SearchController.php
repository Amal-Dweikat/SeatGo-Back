<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
   public function search(Request $request)
{
    $query = Trip::with('driver.user');

    if ($request->FromCity) {
        $query->where('FromCity', $request->FromCity);
    }

    if ($request->ToCity) {
        $query->where('ToCity', $request->ToCity);
    }

    if ($request->DepartureTime) {
        $query->whereTime('DepartureTime', $request->DepartureTime);
    }

    return response()->json(
        $query->get()->map(function ($trip) {
            return [
                'id' => $trip->id,
                'FromCity' => $trip->FromCity,
                'ToCity' => $trip->ToCity,
                'DepartureTime' => $trip->DepartureTime,
                'Price' => $trip->Price,
                'BookedSeats' => $trip->BookedSeats,
                'transport' => $trip->transport,

                'driver_name' => $trip->driver->user->full_name ?? null,
                'driver_image' => $trip->driver->user->profile_picture
                    ? url('storage/' . $trip->driver->user->profile_picture)
                    : null,
            ];
        })
    );
}
}