<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'title', 'slug', 'canonical_url'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function details(): HasMany
    {
        return $this->hasMany(PostDetail::class, 'post_id', 'id');
    }
}
