<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
public function ItemController(Request $request)
{
    $query = Item::query();

    if ($request->from_city) {
    $query->where('from_city', 'like', "%$request->from_city%");
}

if ($request->to_city) {
    $query->where('to_city', 'like', "%$request->to_city%");
}

    if ($request->time) {
        $query->where('time', 'like', $request->time . '%');
    }

    if ($request->transport) {
        $query->where('transport', $request->transport);
    }

    if ($request->price) {
        $query->where('price', '<=', $request->price);
    }

    if ($request->passengers) {
        $query->where('passengers', '<=', $request->passengers);
    }

    $query->orderBy('created_at', $request->sort ?? 'desc');

    return response()->json($query->get());
}
}