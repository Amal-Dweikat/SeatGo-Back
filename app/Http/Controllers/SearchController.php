<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function search(Request $request)
{
    $query = Ride::query();

    if ($request->from) {
        $query->where('from_city', 'LIKE', '%' . $request->from . '%');
    }

    if ($request->to) {
        $query->where('to_city', 'LIKE', '%' . $request->to . '%');
    }

    if ($request->time) {
        $query->where('time', $request->time);
    }

    return response()->json($query->get());
}
}