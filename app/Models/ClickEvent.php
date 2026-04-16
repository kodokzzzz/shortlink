<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClickEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'link_id',
        'clicked_at',
        'referrer',
        'user_agent',
        'browser',
        'device_type',
        'ip_hash',
        'country',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // =============================================
    // Relationships
    // =============================================

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
