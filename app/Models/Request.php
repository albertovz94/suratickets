<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'user_id',
        'device_type',
        'description',
        'urgency',
        'status',
        'assigned_to',
        'admin_note',
        'proof_photo_path',
        'delivery_note',
        'delivered_at'
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(RequestComment::class);
    }
}
