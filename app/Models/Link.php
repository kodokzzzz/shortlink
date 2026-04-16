<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_url',
        'slug',
        'title',
        'status',
        'total_clicks',
        'qr_code_path',
    ];

    protected $casts = [
        'total_clicks' => 'integer',
    ];

    // =============================================
    // Relationships
    // =============================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clickEvents(): HasMany
    {
        return $this->hasMany(ClickEvent::class);
    }

    // =============================================
    // Scopes
    // =============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // =============================================
    // Accessors
    // =============================================

    public function getShortUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getIsInactiveAttribute(): bool
    {
        return $this->status === 'inactive';
    }

    public function getLastClickedAtAttribute()
    {
        $lastClick = $this->clickEvents()->latest('clicked_at')->first();
        return $lastClick ? $lastClick->clicked_at : null;
    }
}
