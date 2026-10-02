<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodRequest extends Model
{
    protected $fillable = [
        'requester_id',
        'blood_group_id',
        'location_id',
        'required_quantity',
        'fulfilled_quantity',
        'required_date',
        'urgency',
        'region',
        'locality',
        'status',
        'closed_at',
    ];

    protected $casts = [
        'required_date' => 'date',
        'closed_at' => 'datetime',
    ];

    /**
     * User who created the blood request.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requester_id'
        );
    }

    /**
     * Required blood group.
     */
    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(
            BloodGroup::class,
            'blood_group_id'
        );
    }
    public function location(): BelongsTo
{
    return $this->belongsTo(
        Location::class,
        'location_id'
    );
}

    /**
     * Responses from users who want to help.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(
            BloodRequestResponse::class,
            'blood_request_id'
        );
    }

    /**
     * Remaining units required.
     */
    public function getRemainingQuantityAttribute(): int
    {
        return max(
            0,
            $this->required_quantity -
            $this->fulfilled_quantity
        );
    }
    /**
 * Mark the request as expired when its required date has passed.
 */
public function expireIfNeeded(): bool
{
    if (
        $this->status !== 'active' ||
        $this->required_date->isFuture()
    ) {
        return false;
    }

    $this->update([
        'status' => 'expired',
        'closed_at' => now(),
    ]);

    return true;
}
}