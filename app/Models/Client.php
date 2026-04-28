<?php

namespace App\Models;

use App\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasAuditLog;

    protected $fillable = ['name', 'image_url', 'is_active', 'sort_order'];

    protected $appends = ['logo_url'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getLogoUrlAttribute(): string
    {
        if (!$this->image_url) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=random';
        }
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }
        return asset('storage/' . $this->image_url);
    }
}
