<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('create', $model, null, $model->getAttributes());
        });

        static::updated(function ($model) {
            self::logActivity('update', $model, $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model) {
            self::logActivity('delete', $model, $model->getAttributes(), null);
        });
    }

    protected static function logActivity(string $action, $model, ?array $oldValues, ?array $newValues)
    {
        // Extract resource name from model class (e.g., App\Models\User -> User)
        $modelClass = get_class($model);
        $resourceName = class_basename($modelClass);
        
        ActivityLog::create([
            'action' => $action,
            'model_type' => $modelClass,
            'resource_name' => $resourceName,
            'model_uuid' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_uuid' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
