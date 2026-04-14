<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Car  extends Model

{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'type',
        'plate_number',
        'color',
        'seats'
    ];
}
