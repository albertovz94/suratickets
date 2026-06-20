<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\TicketObserver;

#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'sucursal_id',
        'departamento_id',
        'equipo_id',
        'priority',
        'status',
        'creator_id',
        'assigned_to',
        'resolution_summary',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
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
