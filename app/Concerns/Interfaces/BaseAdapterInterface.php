<?php

namespace App\Concerns\Interfaces;

use Illuminate\Support\Collection;

interface BaseAdapterInterface
{
    public function posts(string $apiKey, int $userId): Collection;
}
