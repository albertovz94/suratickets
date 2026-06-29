<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class ScheduleService
{
    /**
     * Determine if a user is currently scheduled/working.
     *
     * @param User $user
     * @param Carbon|null $time Check for a specific time, default is now.
     * @return bool
     */
    public function isUserWorkingNow(User $user, ?Carbon $time = null): bool
    {
        $time = $time ?? Carbon::now();
        $schedule = $user->schedule;

        // Outsourcing role checks active work shift
        if ($user->role === 'outsourcing') {
            return $this->hasActiveWorkShift($user, $time);
        }

        // If no schedule exists, fallback to default fixed shift
        if (!$schedule) {
            return $this->isWithinDefaultShift($time);
        }

        // Fixed schedule check
        if ($schedule->type === 'fijo') {
            return $this->isWithinFixedSchedule($schedule, $time);
        }

        // Schedule of type outsourcing
        if ($schedule->type === 'outsourcing') {
            return $this->hasActiveWorkShift($user, $time);
        }

        return false;
    }

    /**
     * Check if user has an active work shift for a specific date/time.
     */
    private function hasActiveWorkShift(User $user, Carbon $time): bool
    {
        $activeShift = $user->workShifts()
            ->whereDate('date', $time->toDateString())
            ->where(function($query) {
                $query->where('status', 'en_curso')
                      ->orWhere(function($q) {
                          $q->whereNotNull('check_in')->whereNull('check_out');
                      });
            })->first();

        return $activeShift !== null;
    }

    /**
     * Check if current time is within default fixed shift (7:00 AM - 10:30 PM).
     */
    private function isWithinDefaultShift(Carbon $time): bool
    {
        $currentTime = $time->format('H:i:s');
        $start = '07:00:00';
        $end = '22:30:00';

        return $currentTime >= $start && $currentTime <= $end;
    }

    /**
     * Check if a time falls within a User's fixed schedule.
     */
    private function isWithinFixedSchedule($schedule, Carbon $time): bool
    {
        $dayOfWeek = strtolower($time->englishDayOfWeek);
        $startField = $dayOfWeek . '_start';
        $endField = $dayOfWeek . '_end';

        $start = $schedule->$startField;
        $end = $schedule->$endField;

        if ($start && $end) {
            $startTime = Carbon::createFromFormat('H:i:s', $start);
            $endTime = Carbon::createFromFormat('H:i:s', $end);
            $currentTime = $time->format('H:i:s');

            if ($endTime->lessThan($startTime)) {
                // Night shift (e.g. 22:00 to 06:00)
                return $currentTime >= $start || $currentTime <= $end;
            } else {
                // Regular shift (e.g. 08:00 to 17:00)
                return $currentTime >= $start && $currentTime <= $end;
            }
        }

        return false;
    }
}
