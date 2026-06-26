<?php

namespace App\Services;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketStatsService
{
    /**
     * Get chart statistics based on the specified time filter.
     * 
     * @param string $timeFilter 'day', 'week', 'month'
     * @return array
     */
    public function getDashboardChartsData(string $timeFilter): array
    {
        $user = Auth::user();
        $baseQuery = Ticket::query();

        if (!$user->hasAdminAccess()) {
            $baseQuery->where('creator_id', $user->id);
        }

        $labels = [];
        $totalData = [];
        $openData = [];
        $resolvedData = [];

        if ($timeFilter === 'month') {
            $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            $totalData = array_fill(0, 12, 0);
            $openData = array_fill(0, 12, 0);
            $resolvedData = array_fill(0, 12, 0);

            $stats = (clone $baseQuery)
                ->whereYear('created_at', date('Y'))
                ->selectRaw('MONTH(created_at) as month, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('month')
                ->get();

            foreach ($stats as $stat) {
                $idx = $stat->month - 1;
                $totalData[$idx] = (int)$stat->total;
                $openData[$idx] = (int)$stat->open_count;
                $resolvedData[$idx] = (int)$stat->resolved_count;
            }
        } elseif ($timeFilter === 'week') {
            for ($i = 6; $i >= 0; $i--) {
                $labels[] = Carbon::now()->subDays($i)->format('d/m');
            }
            $totalData = array_fill(0, 7, 0);
            $openData = array_fill(0, 7, 0);
            $resolvedData = array_fill(0, 7, 0);

            $stats = (clone $baseQuery)
                ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->selectRaw('DATE(created_at) as date, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('date')
                ->get();

            foreach ($stats as $stat) {
                $dateFormatted = Carbon::parse($stat->date)->format('d/m');
                $idx = array_search($dateFormatted, $labels);
                if ($idx !== false) {
                    $totalData[$idx] = (int)$stat->total;
                    $openData[$idx] = (int)$stat->open_count;
                    $resolvedData[$idx] = (int)$stat->resolved_count;
                }
            }
        } elseif ($timeFilter === 'day') {
            $labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'];
            $totalData = array_fill(0, 6, 0);
            $openData = array_fill(0, 6, 0);
            $resolvedData = array_fill(0, 6, 0);

            $stats = (clone $baseQuery)
                ->whereDate('created_at', Carbon::today())
                ->selectRaw('FLOOR(HOUR(created_at) / 4) as time_group, count(*) as total, sum(case when status = "abierto" then 1 else 0 end) as open_count, sum(case when status in ("resuelto", "cerrado") then 1 else 0 end) as resolved_count')
                ->groupBy('time_group')
                ->get();

            foreach ($stats as $stat) {
                $idx = (int)$stat->time_group;
                if ($idx >= 0 && $idx < 6) {
                    $totalData[$idx] = (int)$stat->total;
                    $openData[$idx] = (int)$stat->open_count;
                    $resolvedData[$idx] = (int)$stat->resolved_count;
                }
            }
        }

        return [
            'labels' => $labels,
            'total' => $totalData,
            'open' => $openData,
            'resolved' => $resolvedData
        ];
    }
}
