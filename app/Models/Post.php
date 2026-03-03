<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'image',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function readTime($wordsPerMinute = 100): string
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);

        return max(1, $minutes).' min';
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageAttribute($value): ?string
    {
        if (! $value) {
            return null;
        }

        // If it's already a full URL (from factory), return as-is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Otherwise, convert storage path to URL
        return asset('storage/'.$value);
    }
}
