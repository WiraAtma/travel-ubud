<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'image_cover',
        'max_guests',
        'facilities',
        'price',
    ];

    protected $casts = [
        'facilities' => 'array',
        'price'      => 'float',
        'max_guests' => 'integer',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}