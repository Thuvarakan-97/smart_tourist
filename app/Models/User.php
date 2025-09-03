<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'token', // from your SQL dump
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ======================
       Relationships
    ====================== */

    // Tourist Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tourist_id');
    }

    // Room Owner Accommodations
    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'owner_id');
    }

    // Vehicle Owner Vehicles
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'owner_id');
    }

    /* ======================
       Role Helpers
    ====================== */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTourist(): bool
    {
        return $this->role === 'tourist';
    }

    public function isVehicleOwner(): bool
    {
        return $this->role === 'vehicle_owner';
    }

    public function isRoomOwner(): bool
    {
        return $this->role === 'room_owner';
    }
}
