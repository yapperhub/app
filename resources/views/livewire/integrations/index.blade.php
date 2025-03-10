<?php

use App\Http\DataVault\PlatformVault;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function with(PlatformVault $platformVault): array
    {
        return [
            'platforms' => $platformVault->activePlatforms(search: request('q')),
            'headers' => [['key' => 'title', 'label' => 'Title']],
        ];
    }
}; ?>

<div>
    <div class="mb-12 flex items-center justify-between">
        <div>
            <form class="flex items-center gap-3">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    type="search"
                    placeholder="Search posts..."
                    class="h-9 w-96 rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                />
                <x-primary-button>Search</x-primary-button>
            </form>
        </div>
    </div>

    <x-mary-table
        :headers="$headers"
        :rows="$platforms"
        {{-- per-page="perPage" --}}
        :per-page-values="[20, 30, 50, 100]"
        no-headers
        with-pagination
    >
        @scope('cell_title', $platform)
            <div class="flex items-center justify-between border-b-2 pb-5">
                <div class="flex items-center gap-5">
                    <img src="{{ $platform->logo }}" alt="{{ $platform->name }}" class="h-16 w-16 rounded-lg" />
                    <div>
                        <div class="text-2xl">
                            {{ $platform->name }}
                            @if ($platform->credentials(userId: auth()->id())->count())
                                <x-mary-badge value="Connected" class="badge-primary ml-3" />
                            @endif
                        </div>
                        <div class="mb-1 mt-2">{{ $platform->description }}</div>
                        <div class="mb-3 mt-2">
                            <a href="{{ $platform->url }}" target="_blank" class="mr-2 text-sm text-sky-500">
                                {{ $platform->url }}
                            </a>
                        </div>
                    </div>
                </div>
                <x-secondary-link href="{{ route('integrations.show', ['platform' => $platform->id]) }}">
                    @if ($platform->credentials(userId: auth()->id())->count())
                        Update
                    @else
                        Integrate
                    @endif
                </x-secondary-link>
            </div>
        @endscope
    </x-mary-table>
</div>
