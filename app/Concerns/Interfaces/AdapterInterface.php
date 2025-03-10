<?php

namespace App\Concerns\Interfaces;

use Illuminate\Support\Collection;

interface AdapterInterface
{
    public function posts(string $apiKey, int $userId): Collection;
}
