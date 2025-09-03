<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'type',
        'description',
        'price_per_day',
        'image_url',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    /* ======================
       Relationships
    ====================== */

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'item_id')->where('item_type', 'vehicle');
    }
}
