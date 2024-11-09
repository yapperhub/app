<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'description', 'url', 'logo', 'credentials', 'is_active'];

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';
}
