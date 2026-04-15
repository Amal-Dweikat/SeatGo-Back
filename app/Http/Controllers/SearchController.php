<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function search(Request $request)
{
    $query = Trip::query();

    if ($request->from) {
        $query->where('FromCity', 'LIKE', '%' . $request->from . '%');
    }

    if ($request->to) {
        $query->where('ToCity', 'LIKE', '%' . $request->to . '%');
    }

    if ($request->time) {
        $query->where('DepartureTime', $request->time);
    }

    return response()->json($query->get());
}
}
