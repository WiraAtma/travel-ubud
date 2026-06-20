<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}