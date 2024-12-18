<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class PostDetail extends Model
{
    use HasUuids;

    protected $fillable = ['post_id', 'platform_id', 'content', 'excerpt', 'featured_image', 'published_at'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }
}
