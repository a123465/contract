<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function isPremium()
    {
        return $this->isActive() && $this->plan === 'premium';
    }
}
