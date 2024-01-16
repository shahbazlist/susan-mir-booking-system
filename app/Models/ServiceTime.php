<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceTime extends Model
{
    use HasFactory;

    // public function serviceTime(): BelongsTo
    // {
    //     return $this->belongsTo(ServiceAvailable::class);
    // }

    
}
