<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentReview extends Model
{
    protected $fillable = [
        'reviewable_type', 'reviewable_id', 'reporter_id', 'reviewer_id',
        'status', 'reason', 'metadata', 'auto_checks', 'action', 'resolved_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'auto_checks' => 'array',
        'action' => 'array',
        'resolved_at' => 'datetime',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
