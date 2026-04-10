<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityVerification extends Model
{
    protected $fillable = [
        'user_id', 'status', 'submitted_data', 'documents', 'reviewer_id', 'review_reason', 'reviewed_at',
    ];

    protected $casts = [
        'submitted_data' => 'array',
        'documents' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
