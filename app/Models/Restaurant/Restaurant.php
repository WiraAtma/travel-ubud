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
        return $this->hasMany(RestaurantMenu::class)->orderBy('category')->orderBy('name');
    }

    public function links()
    {
        return $this->hasMany(RestaurantLink::class)->orderBy('sort_order');
    }

    public function comments()
    {
        return $this->hasMany(RestaurantComment::class)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user'])
                    ->orderBy('created_at', 'desc');
    }

    public function ratings()
    {
        return $this->hasMany(RestaurantRating::class);
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