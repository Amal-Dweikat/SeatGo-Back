<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepeatTrip extends Model
{
    use HasFactory;
    protected $casts = [
        'DriverSelectedDays' => 'array',
    ];
    protected $fillable = [
        'EndRepeat',
        'DriverSelectedDays',
    ];


    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

}
