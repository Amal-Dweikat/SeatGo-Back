<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
public function ItemController(Request $request)
{
    $query = Trip::with('driver.user');

    if ($request->from_city) {
    $query->where('FromCity', 'like', "%$request->from_city%");
}

if ($request->to_city) {
    $query->where('ToCity', 'like', "%$request->to_city%");
}

    if ($request->time) {
        $query->where('DepartureTime', 'like', $request->time . '%');
    }

    if ($request->transport) {
        $query->where('transport', $request->transport);
    }

    if ($request->price) {
        $query->where('Price', '<=', $request->price);
    }

    if ($request->passengers) {
        $query->where('BookedSeats', '<=', $request->passengers);
    }

    $query->orderBy('created_at', $request->sort ?? 'desc');

    return response()->json($query->get());
}
}
