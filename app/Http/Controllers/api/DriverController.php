<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Car;
use App\Models\Trip;
use App\Models\Booking;

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

        $user->role = 'driver';
        $user->save();

        Car::create([
            'driver_id' => $driver->id,
            'type' => $request->type,
            'plate_number' => $request->plate_number,
            'color' => $request->color,
            'seats' => $request->seats,
        ]);

        return response()->json([
            'message' => 'Driver request submitted successfully',
            'user' => $user
        ]);
    }


    public function stats()
    {
        $user = auth()->user();

        $driver = Driver::where('user_id', $user->id)->first();

        if (!$driver) {
            return response()->json([
                'upcoming_trips' => 0,
                'upcoming_passengers' => 0,
                'completed_trips' => 0,
            ]);
        }


        $upcomingTrips = $driver->trips()
            ->where('DepartureTime', '>', now())
            ->where('status', '!=', 'completed')
            ->count();


        $passengers = Booking::whereHas('trip', function ($q) use ($driver) {
            $q->where('driver_id', $driver->id)
                ->where('status', '!=', 'completed');
        })->sum('numSeatBooked');


        $completedTrips = $driver->trips()
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'upcoming_trips' => $upcomingTrips,
            'upcoming_passengers' => $passengers,
            'completed_trips' => $completedTrips,
        ]);
    }


    public function currentTrip()
    {
        $user = auth()->user();

        $driver = Driver::where('user_id', $user->id)->first();

        if (!$driver) {
            return response()->json(null);
        }


        $trip = $driver->trips()
            ->where('DepartureTime', '<=', now())
            ->where('ArrivalTime', '>=', now())
            ->first();

        if (!$trip) {
            return response()->json(null);
        }

        $passengers = Booking::where('trip_id', $trip->id)
            ->sum('numSeatBooked');

        return response()->json([
            'id' => $trip->id,
            'from' => $trip->FromCity,
            'to' => $trip->ToCity,
            'time' => $trip->DepartureTime,
            'passengers_count' => $passengers,
            'status' => $trip->status,
        ]);
    }


    public function startTrip($id)
    {
        $trip = Trip::findOrFail($id);

        $trip->status = 'active';
        $trip->save();

        return response()->json([
            'message' => 'Trip started',
            'trip' => $trip
        ]);
    }


    public function endTrip($id)
    {
        $trip = Trip::findOrFail($id);

        $trip->status = 'completed';
        $trip->save();

        return response()->json([
            'message' => 'Trip ended',
            'trip' => $trip
        ]);
    }
}
