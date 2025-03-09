<?php

namespace App\Http\DataVault;

use App\Models\Platform;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlatformVault
{
    public function activePlatforms(?string $search, int $perPage = 20): LengthAwarePaginator
    {
        return Platform::query()->where('is_active', true)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })->paginate($perPage);
    }

    public function activePlatformsCount(): int
    {
        return Platform::query()->where('is_active', true)->count();
    }
}
