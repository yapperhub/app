<?php

use App\Http\DataVault\CredentialVault;
use App\Jobs\SyncDev;
use App\Models\Platform;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast;

    public string $apiKey = '';

    public bool $canSync = false;

    public Platform $platform;

    #[NoReturn]
    public function mount(Platform $platform): void
    {
        $this->platform = $platform;
        $credential = $platform->credentials(userId: auth()->id())->first();
        if ($credential) {
            $this->apiKey = decrypt($credential->value);
            $this->canSync = true;
        }
    }

    #[NoReturn]
    public function submit(CredentialVault $credentialVault): void
    {
        $validated = $this->validate([
            'apiKey' => ['required', 'string', 'max:255'],
        ]);

        $credentialVault->revoke(platform: $this->platform, userId: auth()->id());
        $credentialVault->save(
            platform: $this->platform,
            userId: auth()->id(),
            key: 'apiKey',
            value: $validated['apiKey'],
        );

        $this->toast(
            type: 'success',
            title: 'Api Key is saved! for Dev',
            description: 'Api Key is saved!',
            position: 'toast-top toast-end',
            timeout: 4000,
        );

        $this->canSync = true;
    }

    public function sync(): void
    {
        $credential = $this->platform->credentials(userId: auth()->id())->first();
        SyncDev::dispatch(userId: auth()->id(), apiKey: decrypt($credential->value));

        $this->toast(
            type: 'success',
            title: 'Synchronization request has been initiated!',
            description: 'Synchronization request has been initiated!',
            position: 'toast-top toast-end',
            timeout: 4000,
        );
    }
}; ?>

<div>
    <x-mary-alert icon="o-exclamation-triangle" class="alert-warning">
        Your API key will be
        <strong>Encrypted</strong>
        before saving. We
        <strong>don't</strong>
        store API key in plain text.
    </x-mary-alert>

    <form wire:submit.prevent="submit" class="mt-12" enctype="multipart/form-data" method="post">
        <div class="container mx-auto mt-4 text-lg">
            <div class="w-1/2 space-y-4">
                <div class="space-y-1">
                    <x-input-label for="title" required="true">API Key</x-input-label>
                    <x-text-input id="api-key" name="apiKey" type="text" wire:model="apiKey" class="w-full" required />
                </div>
            </div>
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Save</x-primary-button>
                @if ($canSync)
                    <x-secondary-button class="ml-2" wire:click="sync">Sync</x-secondary-button>
                @endif
            </div>
        </div>

        <h2 class="mt-8 text-lg font-semibold">How to get API Key?</h2>
        <p class="mb-2 mt-2">To get the API Key, you need to follow the below steps:</p>
        <ul>
            <li>
                - Go to the
                <a href="https://dev.to/settings/extensions" target="_blank" class="text-blue-500">dev.to settings</a>
            </li>
            <li>- In the bottom of the page, you will see "DEV Community API Keys" section.</li>
            <li>- Generate a new API key.</li>
        </ul>
    </form>
</div>
