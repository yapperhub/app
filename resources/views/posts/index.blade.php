<x-app-layout>
    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        <x-slot name="header">
            <x-h2-heading>Posts</x-h2-heading>
        </x-slot>

        <livewire:posts.index />
    </div>
</x-app-layout>
