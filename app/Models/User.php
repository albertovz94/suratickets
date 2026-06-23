<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'last_name', 'email', 'phone', 'password', 'username', 'sucursal_id', 'departamento_id', 'rol', 'status', 'avatar', 'bio', 'display_preference'])]
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

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'creator_id');
    }

    public function scopeAdmins($query)
    {
        return $query->where('rol', 'admin');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function assignedEquipos()
    {
        return $this->hasMany(Equipo::class, 'assigned_to');
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
        $schedule = $this->schedule;
        if (!$schedule) return false;

        $now = \Carbon\Carbon::now();

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
}
