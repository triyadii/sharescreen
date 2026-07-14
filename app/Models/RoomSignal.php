<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomSignal extends Model
{
    protected $fillable = ['room_code', 'sender_id', 'recipient_id', 'type', 'payload'];
}
