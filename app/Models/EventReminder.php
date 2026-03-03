<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventReminder extends Model
{
    protected $fillable = [
        'event_id',
        'email',
        'minutes_before',
        'notify_at',
        'sent',
        'sent_at',
    ];

    protected $casts = [
        'notify_at' => 'datetime',
        'sent_at'   => 'datetime',
        'sent'      => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
