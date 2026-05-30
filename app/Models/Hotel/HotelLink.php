<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'label',
        'url',
        'image_cover',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}