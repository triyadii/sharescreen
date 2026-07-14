<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreenRoom extends Model
{
    protected $fillable = ['code', 'host_id', 'status', 'mode'];
}
