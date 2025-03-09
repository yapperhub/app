<?php

use App\Http\DataVault\CredentialVault;
use App\Models\Credential;
use App\Models\Platform;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast;

    public string $apiKey = '';

    public Platform $platform;

    #[NoReturn]
    public function mount(Platform $platform): void
    {
        $this->platform = $platform;

        $credential = Credential::query()->where('platform_id', $platform->id)->first();
        if ($credential) {
            $this->apiKey = $credential->value;
        }
    }

    #[NoReturn]
    public function submit(CredentialVault $credentialVault): void
    {
        $validated = $this->validate([
            'apiKey' => ['required', 'string', 'max:255'],
        ]);

        $credentialVault->revoke(platform: $this->platform, userId: auth()->id());
        $credentialVault->save(platform: $this->platform, userId: auth()->id(), key: 'apiKey', value: $validated['apiKey']);

        $this->toast(
            type: 'success',
            title: 'Api Key is saved! for Dev',
            description: 'Api Key is saved!',
            position: 'toast-top toast-end',
            timeout: 4000,
        );
    }
}; ?>

<div>
    <form wire:submit.prevent="submit" enctype="multipart/form-data" method="post">
        <div class="container mx-auto mt-4 text-lg">
            <div class="w-1/2 space-y-4">
                <div class="space-y-1">
                    <x-input-label for="title" required="true">API Key</x-input-label>
                    <x-text-input id="api-key" name="apiKey" type="text" wire:model="apiKey" class="w-full" required />
                </div>
            </div>
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </div>
    </form>
</div>
