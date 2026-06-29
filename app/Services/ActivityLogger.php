<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log a user activity in the database.
     *
     * @param string $action The action performed (e.g. 'created', 'updated', 'deleted')
     * @param Model|null $model The eloquent model target of the action
     * @param string|null $description Custom detail/context about the action
     * @return ActivityLog|null
     */
    public static function log(string $action, ?Model $model = null, ?string $description = null): ?ActivityLog
    {
        try {
            return ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => $model ? get_class($model) : null,
                'model_id' => $model ? $model->getKey() : null,
                'description' => $description,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            // Fail silently to prevent database errors from breaking core business logic
            return null;
        }
    }
}
