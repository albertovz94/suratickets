<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'last_name', 'email', 'phone', 'password', 'username', 'branch_id', 'department_id', 'role', 'status', 'avatar', 'bio', 'display_preference'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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

    public function scopeAssignableAdmins($query)
    {
        return $query->where('role', 'admin')->where('username', '!=', 'admin_sistemas');
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
        return resolve(\App\Services\ScheduleService::class)->isUserWorkingNow($this);
    }

    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'outsourcing']);
    }
}
