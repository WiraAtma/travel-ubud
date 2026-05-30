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
        'categories' => 'array', 
        'rating'     => 'float',
        'banned'     => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function links()
    {
        return $this->hasMany(DestinationLink::class)->orderBy('sort_order');
    }
}
