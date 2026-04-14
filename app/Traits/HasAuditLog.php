<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait HasAuditLog
{
    public static function bootHasAuditLog(): void
    {
        static::created(function ($model) {
            self::writeAuditLog($model, 'created', [], $model->getAttributes());
        });

        static::updated(function ($model) {
            $old = array_intersect_key($model->getOriginal(), $model->getDirty());
            $new = $model->getDirty();
            self::writeAuditLog($model, 'updated', $old, $new);
        });

        static::deleted(function ($model) {
            $event = method_exists($model, 'isForceDeleting') && $model->isForceDeleting()
                ? 'force_deleted'
                : 'deleted';
            self::writeAuditLog($model, $event, $model->getAttributes(), []);
        });

        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                self::writeAuditLog($model, 'restored', [], $model->getAttributes());
            });
        }
    }

    protected static function writeAuditLog($model, string $event, array $old, array $new): void
    {
        $user = Auth::user();

        AuditLog::create([
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            'event'          => $event,
            'user_type'      => $user ? get_class($user) : null,
            'user_id'        => $user?->id,
            'old_values'     => empty($old) ? null : $old,
            'new_values'     => empty($new) ? null : $new,
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }
}
