<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tourist_id',
        'item_type',
        'item_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /* ======================
       Relationships
    ====================== */

    public function tourist()
    {
        return $this->belongsTo(User::class, 'tourist_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'item_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'item_id');
    }

    public function bookable()
    {
        return $this->morphTo('item', 'item_type', 'item_id');
    }
}
