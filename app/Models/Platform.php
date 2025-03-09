<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'description', 'url', 'logo', 'is_active'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function credentials(int $userId): Collection
    {
        return once(function () use ($userId) {
            return Credential::query()->where('user_id', $userId)
                ->where('platform_id', $this->id)
                ->get();
        });
    }
}
