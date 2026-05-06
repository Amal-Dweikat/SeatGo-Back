<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller

{
    public function search(Request $request)
    {
        $query = Trip::query();

        if ($request->FromCity) {
            $query->where('FromCity', 'like', "%{$request->FromCity}%");
        }

        if ($request->ToCity) {
            $query->where('ToCity', 'like', "%{$request->ToCity}%");
        }

        if ($request->DepartureTime) {
            $query->where('DepartureTime', 'like', $request->DepartureTime . '%');
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

        $sort = $request->sort == 'asc' ? 'asc' : 'desc';
        $query->orderBy('created_at', $sort);
        return response()->json($query->get());
    }
}
