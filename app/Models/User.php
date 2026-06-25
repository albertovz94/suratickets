<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'last_name', 'email', 'phone', 'password', 'username', 'branch_id', 'department_id', 'role', 'status', 'avatar', 'bio', 'display_preference'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'creator_id');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function assignedDevices()
    {
        return $this->hasMany(Device::class, 'assigned_to');
    }

    public function getDisplayNameAttribute()
    {
        if ($this->display_preference === 'username' && $this->username) {
            return $this->username;
        }
        
        if ($this->display_preference === 'full_name' && $this->last_name) {
            return $this->name . ' ' . $this->last_name;
        }

        return $this->name;
    }

    public function getAvatarPathAttribute()
    {
        if (!$this->avatar) return null;
        if (str_starts_with($this->avatar, 'http')) return $this->avatar;
        return asset('storage/' . $this->avatar);
    }

    public function schedule()
    {
        return $this->hasOne(UserSchedule::class);
    }

    public function workShifts()
    {
        return $this->hasMany(WorkShift::class);
    }

    public function isWorkingNow()
    {
        $now = \Carbon\Carbon::now();
        $schedule = $this->schedule;

        if ($this->role === 'outsourcing') {
            $activeShift = $this->workShifts()->whereDate('date', $now->toDateString())
                ->where(function($query) {
                    $query->where('status', 'en_curso')
                          ->orWhere(function($q) {
                              $q->whereNotNull('check_in')->whereNull('check_out');
                          });
                })->first();
            return $activeShift !== null;
        }

        if (!$schedule) {
            // Horario por defecto: 7 am a 10:30 pm
            $currentTime = $now->format('H:i:s');
            $start = '07:00:00';
            $end = '22:30:00';
            return $currentTime >= $start && $currentTime <= $end;
        }

        if ($schedule->type === 'fijo') {
            $dayOfWeek = strtolower($now->englishDayOfWeek);
            $startField = $dayOfWeek . '_start';
            $endField = $dayOfWeek . '_end';

            $start = $schedule->$startField;
            $end = $schedule->$endField;

            if ($start && $end) {
                $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $start);
                $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $end);
                $currentTime = $now->format('H:i:s');

                if ($endTime->lessThan($startTime)) {
                    // Turno nocturno (ej: 22:00 a 06:00)
                    return $currentTime >= $start || $currentTime <= $end;
                } else {
                    // Turno normal (ej: 08:00 a 17:00)
                    return $currentTime >= $start && $currentTime <= $end;
                }
            }
            return false;
        }

        if ($schedule->type === 'outsourcing') {
            $activeShift = $this->workShifts()->whereDate('date', $now->toDateString())
                ->where(function($query) {
                    $query->where('status', 'en_curso')
                          ->orWhere(function($q) {
                              $q->whereNotNull('check_in')->whereNull('check_out');
                          });
                })->first();
            return $activeShift !== null;
        }

        return false;
    }

    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'outsourcing']);
    }
}
