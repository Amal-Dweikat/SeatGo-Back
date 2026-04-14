<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'driver_name',
        'driver_image',
        'from_city',
        'to_city',
        'price',
        'transport',
        'passengers',
        'time',
        'created_at',
    ];
}