<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerChannelIdentifier extends Model
{
    use HasUlids;

    protected $fillable = [
        'customer_id',
        'channel',
        'provider',
        'identifier',
        'verified_at',
        'metadata',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

// Whos is the cuatomer on a specific channel.
