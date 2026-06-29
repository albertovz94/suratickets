<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'specs',
        'type',
        'serial_number',
        'branch_id',
        'department_id',
        'assigned_to',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
