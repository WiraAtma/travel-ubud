<?php

namespace App\Models\Hotel;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_cover',
        'address',
        'phone',
        'start_price',
        'facilities',
        'checkin_time',
        'checkout_time',
        'description',
        'notes',
        'rating',
        'rating_count',
        'banned',
        'id_author',
    ];

    protected $casts = [
        'facilities'   => 'array',
        'start_price'  => 'float',
        'rating'       => 'float',
        'banned'       => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function links()
    {
        return $this->hasMany(HotelLink::class)->orderBy('sort_order');
    }
}