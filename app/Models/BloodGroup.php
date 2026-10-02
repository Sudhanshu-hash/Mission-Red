<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodGroup extends Model
{
    protected $fillable = [
        'name',
    ];

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }
}