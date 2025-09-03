<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'dest_id',
        'title',
        'description',
        'price_per_night',
        'image_url',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
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

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'dest_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'item_id')->where('item_type', 'accommodation');
    }
}
