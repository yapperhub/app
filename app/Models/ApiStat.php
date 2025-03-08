<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiStat extends Model
{
    protected $fillable = [
        'user_id',
        'api_name',
    ];
}
