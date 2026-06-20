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

    public function comments()
    {
        return $this->hasMany(HotelComment::class)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user'])
                    ->orderBy('created_at', 'desc');
    }

    public function ratings()
    {
        return $this->hasMany(HotelRating::class);
    }

    public function recalculateRating(): void
    {
        $ratings = $this->ratings();
        $count   = $ratings->count();
        $avg     = $count > 0 ? round($ratings->avg('score'), 1) : 0;

        $this->update([
            'rating'       => $avg,
            'rating_count' => $count,
        ]);
    }
}