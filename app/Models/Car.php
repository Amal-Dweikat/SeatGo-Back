<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Car  extends Model
{
    protected $fillable = [
        'driver_id',
        'type',
        'plate_number',
        'color',
        'seats'
    ];
}
