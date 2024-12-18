<?php
use App\Models\Platform;

$platform = Platform::query()
    ->where('slug', request()->route('platform'))
    ->first();
?>

<x-app-layout>
    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        <x-slot name="header">
            <x-h2-heading>Edit Post ( {{ $platform->name }} )</x-h2-heading>
        </x-slot>

        <livewire:posts.edit />
    </div>
</x-app-layout>
