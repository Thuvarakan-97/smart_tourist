<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'rating',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'rating' => 'float',
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
    ];

    /* ======================
       Relationships
    ====================== */

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'dest_id');
    }
}
