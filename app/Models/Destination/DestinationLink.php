<?php

namespace App\Models\Destination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'label',
        'url',
        'image_cover',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}