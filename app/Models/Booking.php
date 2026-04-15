<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
      'UserSelectedDays' => 'array',
    ];

    protected $fillable = [
        'trip_id',
        'user_id',
        'UserWantRepeat',
        'EndRepeat',
        'UserSelectedDays',
        'numSeatBooked',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

}
