<?php

namespace App\Http\DataVault;

use App\Models\Credential;
use App\Models\Platform;

class CredentialVault
{
    public function save(Platform $platform, int $userId, string $key, string $value): Credential
    {
        return Credential::query()->create([
            'platform_id' => $platform->id,
            'user_id' => $userId,
            'key' => $key,
            'value' => encrypt($value),
        ]);
    }

    public function revoke(Platform $platform, int $userId): void
    {
        Credential::query()->where('platform_id', $platform->id)->where('user_id', $userId)->delete();
    }

    public function connectedIntegrationsCount(int $userId): int
    {
        return Credential::query()->where('user_id', $userId)
            ->distinct('platform_id')
            ->count();
    }
}
