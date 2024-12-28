<x-app-layout>
    <x-slot name="header">
        <x-h2-heading>Dashboard</x-h2-heading>
    </x-slot>

    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        <div class="text-gray-500">
            {{ __("You're logged in as ") }}
            <span class="">{{ auth()->user()->name }} ({{ auth()->user()->email }})</span>
        </div>
    </div>

    <livewire:dashboard />
</x-app-layout>
