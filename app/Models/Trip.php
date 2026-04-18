<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
use HasFactory;
 protected $table = 'trips';
protected $fillable = [
'FromCity',
'ToCity',
'FromRegion',
'ToRegion',
'DepartureTime',
'ArrivalTime',
'DateTrip',
'Price',
'BookedSeats',
'TotalSeats',
'replied_admin',
'status',
'trip_repeat',
    'transport',
    'note'
];


public function driver()
{
return $this->belongsTo(Driver::class);
}

public function bookings()
{
return $this->hasMany(Booking::class);
}

 public function repeatTrip()
    {
        return $this->hasOne(RepeatTrip::class);
    }

}