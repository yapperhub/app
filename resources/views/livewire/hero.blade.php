<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component
{
    public string $email;

    public function handle(): Livewire\Features\SupportRedirects\Redirector
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::query()
            ->where('email', $this->email)
            ->first();

        if ($user) {
            return redirect(route('login', ['with' => $this->email]));
        }

        return redirect(route('register', ['with' => $this->email]));
    }
}; ?>

<div>
    <section class="bg-gray-100 text-gray-800" id="hero">
        <x-public-container>
            <div class="xl:h-112 2xl:h-128 mt-8 flex h-72 items-center justify-center p-6 sm:h-80 lg:mt-0 lg:h-96">
                <img
                    src="{{ url('/img/welcome/network.svg') }}"
                    alt=""
                    class="xl:h-112 2xl:h-128 h-72 object-contain sm:h-80 lg:h-96"
                />
            </div>
            <div class="flex flex-col justify-center rounded-sm p-6 text-center lg:max-w-xl lg:text-left xl:max-w-2xl">
                <h1 class="flex flex-col space-y-2 text-4xl font-bold leading-none sm:text-5xl">
                    <span>Powering</span>
                    <span>
                        <span class="text-sky-600">Cross-Platform</span>
                        Blogging
                    </span>
                </h1>
                <p class="mb-8 mt-6 text-lg sm:mb-12">
                    Yapper Hub enables cross-platform blogging with seamless integration to Dev.to, Hashnode, and Medium
                    etc. — expand your reach effortlessly from one platform.
                </p>
                <div
                    class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-center sm:space-x-4 sm:space-y-0 lg:justify-start"
                >
                    @if (! auth()->check())
                        <div class="flex w-full flex-row">
                            <input
                                wire:model="email"
                                type="email"
                                placeholder="example@email.com"
                                class="w-4/5 rounded-l-lg p-3 sm:w-3/4"
                            />
                            <button
                                type="button"
                                wire:click="handle"
                                class="w-1/5 rounded-r-lg bg-sky-600 p-3 font-semibold text-gray-50 sm:w-1/4"
                            >
                                Get Started
                            </button>
                        </div>
                    @else
                        <a
                            rel="noopener noreferrer"
                            href="{{ route('dashboard') }}"
                            class="rounded bg-sky-600 px-8 py-3 text-lg font-semibold text-gray-50"
                            wire:navigate
                        >
                            Got to Dashboard
                        </a>
                    @endif
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </x-public-container>
    </section>
</div>
