<?php

namespace App\Models\article;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_cover',
        'content',
        'id_author',
        'banned',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_author');
    }
}
