<?php

namespace App\Models\Destination;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_cover',
        'content',
        'location',
        'categories',
        'rating',
        'rating_count',
        'banned',
        'id_author',
    ];

    protected $casts = [
        'categories'   => 'array',
        'rating'       => 'float',
        'banned'       => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function links()
    {
        return $this->hasMany(DestinationLink::class)->orderBy('sort_order');
    }

    public function comments()
    {
        return $this->hasMany(DestinationComment::class)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user'])
                    ->orderBy('created_at', 'desc');
    }

    public function ratings()
    {
        return $this->hasMany(DestinationRating::class);
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