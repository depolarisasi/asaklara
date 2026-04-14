<?php

namespace App\Models;

use App\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use SoftDeletes, HasAuditLog;

    protected $fillable = ['title', 'slug', 'description', 'image', 'order', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function features()
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('order');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://picsum.photos/seed/' . $this->slug . '/600/600';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
