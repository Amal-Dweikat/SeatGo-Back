<?php
//



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'role',
        'profile_picture',
        'average_rating',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'rater_user_id');
    }

    public function receivedRatings()
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }
    public function favoriteDrivers()
    {
        return $this->belongsToMany(
            User::class,
            'favorite_drivers',
            'user_id',
            'driver_id'
        );
    }

    /**

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**

     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }

    /**

     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'average_rating' => 'float',
        ];
    }
}
