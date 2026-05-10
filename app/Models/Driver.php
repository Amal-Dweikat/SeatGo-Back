<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'status',
    ];
    public function trips()
{
    return $this->hasMany(Trip::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
