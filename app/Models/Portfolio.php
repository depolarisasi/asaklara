<?php

namespace App\Models;

use App\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use SoftDeletes, HasAuditLog;

    protected $fillable = [
        'title', 'slug', 'description', 'client',
        'year', 'category', 'image', 'featured', 'order', 'active'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'active' => 'boolean',
        'order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('order');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://picsum.photos/seed/' . $this->slug . '/800/600';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
