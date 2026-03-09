<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Crop, 400, 250);

        $this
            ->addMediaConversion('large')
            ->width(1200);
    }

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

    public function imageUrl(string $media = 'preview'): ?string
    {
        $mediaItem = $this->getFirstMedia();
        
        if ($mediaItem) {
            return $mediaItem->getUrl($media);
        }
        
        return null;
    }
}
