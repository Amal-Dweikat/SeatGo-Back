<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Car;

class DriverController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'license_number' => 'required',
            'type' => 'required',
            'plate_number' => 'required',
            'color' => 'required',
            'seats' => 'required',
        ]);

        $user = auth()->user();


        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'status' => 'pending',
        ]);


        Car::create([
            'driver_id' => $driver->id,
            'type' => $request->type,
            'plate_number' => $request->plate_number,
            'color' => $request->color,
            'seats' => $request->seats,
        ]);

        return response()->json([
            'message' => 'Driver request submitted successfully'
        ]);
    }
}
