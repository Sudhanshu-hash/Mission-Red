<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
   protected $fillable = [
    'user_id',
    'phone',
    'blood_group_id',
    'location_id',
    'profile_image_path',
    'phone_verified_at',
    'email_private',
    'phone_private',
    'last_seen_at',
];
protected function casts(): array
{
    return [
        'phone_verified_at' => 'datetime',
        'email_private' => 'boolean',
        'phone_private' => 'boolean',
        'last_seen_at' => 'datetime',
    ];
}
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}