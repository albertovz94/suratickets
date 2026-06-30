<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RouteLog;
use App\Models\ActivityLog;

class PurgeLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:purge {--days=90 : The number of days of logs to retain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge activity and route logs older than X days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $date = now()->subDays($days);

        $this->info("Starting purge of logs older than {$days} days (before {$date->toDateTimeString()})...");

        // Eliminar Route Logs
        $routeLogsCount = RouteLog::where('created_at', '<', $date)->count();
        if ($routeLogsCount > 0) {
            RouteLog::where('created_at', '<', $date)->delete();
            $this->info("- Deleted {$routeLogsCount} route logs.");
        } else {
            $this->comment("- No route logs to delete.");
        }

        // Eliminar Activity Logs
        $activityLogsCount = ActivityLog::where('created_at', '<', $date)->count();
        if ($activityLogsCount > 0) {
            ActivityLog::where('created_at', '<', $date)->delete();
            $this->info("- Deleted {$activityLogsCount} activity logs.");
        } else {
            $this->comment("- No activity logs to delete.");
        }

        $this->info("Purge complete.");
    }
}
