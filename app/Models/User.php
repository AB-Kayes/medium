<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'image',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    { 
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user): void {
            // Generate username from name if not already set
            if (empty($user->username) && !empty($user->name)) {
                $baseUsername = Str::slug($user->name);
                $username = $baseUsername;
                $counter = 1;

                // Ensure username is unique
                while (static::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                $user->username = $username;
            }
        });
    }

    public function imageUrl()
    {
        return $this->image ? Storage::url($this->image) : asset('user.png');
    }

    public function isFollowedBy(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked(?Post $post): bool
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }
}
