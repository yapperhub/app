<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = [
        'platform_id',
        'user_id',
        'key',
        'value',
    ];
}
