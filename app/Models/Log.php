<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'platform_id',
        'method',
        'url',
        'response_status_code',
        'response_time',
        'user_agent',
        'ip_address',
        'request',
        'response',
    ];
}
