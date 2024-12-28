<?php

use App\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;

new class extends Component
{
    public string $accessToken;

    public bool $revokeModal = false;

    #[NoReturn]
    public function mount(): void
    {
        if (
            request()
                ->user()
                ->tokens->count() > 0
        ) {
            $this->accessToken = request()->user()->api_access_token;
        }
    }

    #[NoReturn]
    public function generateAccessToken(): void
    {
        $token = request()
            ->user()
            ->createToken('api-access-token');
        $this->accessToken = $token->plainTextToken;
        User::query()
            ->where('id', request()->user()->id)
            ->update(['api_access_token' => $token->plainTextToken]);
    }

    #[NoReturn]
    public function revokeToken(): void
    {
        request()
            ->user()
            ->tokens()
            ->delete();

        $this->accessToken = '';
        User::query()
            ->where('id', request()->user()->id)
            ->update(['api_access_token' => null]);

        $this->revokeModal = false;
    }
}; ?>

<div>
    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        @if (! $accessToken)
            <p>To access our API, you'll need an API token for secure authentication.</p>
            <p class="mb-4">
                You don't have an access token yet. Please click the button below to generate one. Once generated, you
                can use it to authenticate your API requests.
            </p>

            <b>Note:</b>
            <p>- Keep your token secure; treat it like a password.</p>
            <p>- If your token is lost or compromised, you can always revoke it and generate a new one.</p>

            <div class="mt-8 flex items-center">
                <x-primary-button wire:click="generateAccessToken">Generate</x-primary-button>
            </div>
        @endif

        @if ($accessToken)
            <div class="mt-4 rounded-md bg-gray-100 p-4">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Access Token</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $accessToken }}</p>
                    </div>
                    <div>
                        <x-mary-button
                            label="Revoke Token"
                            @click="$wire.revokeModal = true"
                            class="btn-sm ml-2 bg-red-500 text-white hover:bg-black"
                        />
                    </div>
                </div>

                <p class="mt-12">
                    This API access token is a key used to authenticate and authorize requests to an API. It ensures
                    that the client accessing the API has the right permissions.
                </p>

                <h2 class="mt-2 text-lg font-semibold text-gray-800">Using the Access Token</h2>
                <p class="mb-12">
                    Add the token to the API requests, usually in the request header. The header key is often
                    <b>Authorization</b>
                    , and the value is the token prefixed by the word
                    <b>Bearer.</b>
                </p>

                <code class="language-http mt-12 rounded-md bg-black p-4 text-white">
                    Authorization: Bearer {{ $accessToken }}
                </code>

                <p class="mt-12">
                    <b>Important:</b>
                    Keep your access token secure. Do not share it with anyone or expose it in public repositories.
                </p>

                <p class="mt-2">
                    If you believe your token has been compromised, you can revoke it by clicking the "Revoke Token"
                    button above.
                </p>

                <p class="mt-2">
                    <b>Note:</b>
                    Revoking the token will invalidate it, and you will need to generate a new one.
                </p>
            </div>
        @endif

        <x-mary-modal wire:model="revokeModal" title="Revoke Token" subtitle="Revoke API Access Token" separator>
            <div>
                <p>Are you sure you want to revoke your API access token? This action cannot be undone.</p>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.revokeModal = false" />
                <x-mary-button
                    label="Confirm"
                    class="bg-red-600 text-white hover:bg-red-700"
                    wire:click="revokeToken"
                />
            </x-slot>
        </x-mary-modal>
    </div>
</div>
