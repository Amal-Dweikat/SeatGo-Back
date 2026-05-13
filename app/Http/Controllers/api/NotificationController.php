<?php

namespace App\Http\Controllers\api;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\FavoriteDriver;
use App\Models\Notification;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController
{
    public function changeStatusBooking( $id,Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;

        $booking->save();

        if ($request->status == 'approved') {

            $title = 'Booking Accepted ✅';

            $body = 'Your driver accepted your trip';

            $type = 'booking_accepted';

        } else {

            $title = 'Booking Rejected ❌';

            $body = 'Your driver rejected your trip';

            $type = 'booking_rejected';
        }

        Notification::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->trip_id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
        ]);

        return response()->json([
            'message' => 'Booking status updated'
        ]);
    }
    public function notificationForFavorite( )
    {
        $user = auth()->id();
        $favorites = FavoriteDriver::where('driver_id', $user)->get();
        $driverId = Driver::where('user_id', $user)->first();
        $trip=Trip::where('driver_id', $driverId->id)->orderBy('id', 'desc')->first();
        foreach ($favorites as $favorite) {

              Notification::create([
                'user_id' => $favorite->user_id,
                'booking_id' => $trip->id,
                'title' => 'New Trip 🚗',
                'body' => 'Your favorite driver created a new trip',
                'type' => 'favorite_driver_trip',
            ]);
        }
        return response()->json([
            'notification' => $favorites,
        ]);
    }

    public function getNotification()
    {
        $user = auth()->id();
       $notification= Notification::where("user_id",$user)->where("is_read",false)->get();
        return response()->json([
            'notification' => $notification
        ]);
    }

    public function notificationRead($id)
    {
        $booking = Notification::where("id",$id)->first();

        $booking->is_read = true;
        $booking->save();
        return response()->json([
            'message' => 'Done update'
        ]);
    }
    public function historyNotification()
    {
        $notification = Notification::where("user_id", auth()->id())
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'notification' => $notification
        ]);
    }

}
