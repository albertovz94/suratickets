<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\TicketObserver;

use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'category',
        'attachment_path',
        'branch_id',
        'department_id',
        'device_id',
        'priority',
        'status',
        'creator_id',
        'assigned_to',
        'resolution_summary',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
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

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at', 'asc');
    }
}
