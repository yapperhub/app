<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static findOrFail($route)
 */
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function platformDetails(string $platformSlug): HasOne
    {
        return $this->hasOne(PostDetail::class, 'post_id', 'id')
            ->where(
                'platform_id',
                fn ($query) => $query->select('id')->from('platforms')->where('slug', $platformSlug)
            );
    }
}
