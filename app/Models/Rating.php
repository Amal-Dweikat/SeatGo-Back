<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'trip_id',
        'rater_user_id',
        'rated_user_id',
        'rating',
        'comment'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function rater()
    {
        return $this->belongsTo(User::class, 'rater_user_id');
    }

    public function rated()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }
}
