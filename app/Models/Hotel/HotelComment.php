<?php

namespace App\Models\Hotel;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function parent()
    {
        return $this->belongsTo(HotelComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(HotelComment::class, 'parent_id')
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