<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodRequestResponse extends Model
{
    protected $fillable = [
        'blood_request_id',
        'user_id',
        'response_type',
        'quantity',
        'status',
        'message',
        'responded_at',
        'reviewed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'responded_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Blood request this response belongs to.
     */
    public function bloodRequest(): BelongsTo
    {
        return $this->belongsTo(BloodRequest::class);
    }

    /**
     * User who responded to the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}