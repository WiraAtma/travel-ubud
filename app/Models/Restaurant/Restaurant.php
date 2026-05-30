<?php

namespace App\Models\Restaurant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_cover',
        'address',
        'phone',
        'category',
        'start_price',
        'description',
        'open_time',
        'close_time',
        'notes',
        'rating',
        'rating_count',
        'banned',
        'id_author',
    ];

    protected $casts = [
        'start_price' => 'float',
        'rating'      => 'float',
        'banned'      => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function menus()
    {
        return $this->hasMany(RestaurantMenu::class);
    }
}