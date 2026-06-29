<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteLog extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'method',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
