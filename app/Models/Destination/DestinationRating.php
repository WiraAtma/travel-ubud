<?php

namespace App\Models\Destination;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DestinationRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
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

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}