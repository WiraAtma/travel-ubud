<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'label',
        'url',
        'image_cover',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}