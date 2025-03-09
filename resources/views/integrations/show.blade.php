@php
    use App\Concerns\Constants;
@endphp

<x-app-layout>
    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        <x-slot name="header">
            <x-h2-heading>Integration | {{ $platform->name }}</x-h2-heading>
        </x-slot>

        @if ($platform->slug === Constants::DEV_PLATFORM_SLUG)
            <livewire:integrations.dev :platform="$platform" />
        @endif
    </div>
</x-app-layout>
