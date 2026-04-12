<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%")
                  ->orWhere('transport', 'like', "%{$request->search}%");
            });
        }

        if ($request->city) {
            $query->where('city', $request->city);
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