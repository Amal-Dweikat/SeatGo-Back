<?php

namespace App\Http\Controllers\api;

use App\Models\Booking;
use App\Models\Notification;
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

        // تحديد بيانات notification
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
            'booking_id' => $booking->id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
        ]);

        return response()->json([
            'message' => 'Booking status updated'
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
}
