<?php

namespace App\Models;

use App\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes, HasAuditLog;

    protected $fillable = ['name', 'role', 'image', 'order', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('order');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=random';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
