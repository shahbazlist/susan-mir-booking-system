<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceAvailable extends Model
{
    use HasFactory;
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function serviceTime(): HasMany
    {
        return $this->hasMany(serviceTime::class);
    }
}
