<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ItemController extends Controller

{

public function search(Request $request)
{
    $now = Carbon::now();

    $query = Trip::query()

        ->whereNotIn('status', ['completed', 'cancelled'])

        ->where(function ($q) use ($now) {
            $q->where('DateTrip', '>', $now->toDateString())
              ->orWhere(function ($q2) use ($now) {
                  $q2->where('DateTrip', $now->toDateString());
              });
        })

        ->whereColumn('BookedSeats', '<', 'TotalSeats');

    if ($request->FromCity) {
        $query->where('FromCity', 'like', "%{$request->FromCity}%");
    }

    if ($request->ToCity) {
        $query->where('ToCity', 'like', "%{$request->ToCity}%");
    }

    if ($request->DepartureTime) {
        $query->where('DepartureTime', 'like', $request->DepartureTime . '%');
    }

    return response()->json($query->get());
}
}
