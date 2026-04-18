<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $query = Trip::with('driver')->get();

    if ($request->FromCity) {
        $query->where('FromCity', $request->FromCity);
    }

    if ($request->ToCity) {
        $query->where('ToCity', $request->ToCity);
    }

    if ($request->DepartureTime) {
        $query->whereDate('DepartureTime', $request->DepartureTime);
    }

    return response()->json($query->get());
}
}