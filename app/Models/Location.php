<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    protected $fillable = [
        'state',
        'city',
        'locality',
        'pincode',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public function bloodRequests(): HasMany
{
    return $this->hasMany(
        BloodRequest::class,
        'location_id'
    );
}
}