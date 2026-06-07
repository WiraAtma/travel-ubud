<?php

namespace App\Models\Destination;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DestinationComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function parent()
    {
        return $this->belongsTo(DestinationComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(DestinationComment::class, 'parent_id')
                    ->with('user')
                    ->orderBy('created_at', 'asc');
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->user->name));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
        }
        return $initials ?: 'U';
    }
}