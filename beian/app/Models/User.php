<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

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
        'username',
        'name',
        'nickname',
        'email',
        'password',
        'role',
        'real_name',
        'id_number',
        'id_documents',
        'id_status',
        'avatar',
        'phone',
        'bio',
        'birthday',
        'gender',
        'occupation',
        'hometown',
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
            'birthday' => 'date',
            'id_number' => 'encrypted',
            'id_documents' => 'array',
            'id_verified_at' => 'datetime',
        ];
    }

    /**
     * 返回头像的可访问 URL（如果有）
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes')->withTimestamps();
    }

    public function favoritedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_favorites')->withTimestamps();
    }

    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class);
    }

    public function isModerator()
    {
        return isset($this->role) && in_array($this->role, ['moderator', 'admin']);
    }

    public function isMember()
    {
        return isset($this->role) && $this->role === 'member' && $this->membership && $this->membership->isActive();
    }

    public function isVerified()
    {
        return isset($this->id_status) && $this->id_status === 'verified';
    }

}
