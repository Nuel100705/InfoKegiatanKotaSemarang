<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = [
        'event_id',
        'endpoint',
        'public_key',
        'auth_token',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
