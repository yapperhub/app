<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>--}}

    <div class="container mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="text-gray-500">
            {{ __("You're logged in as ") }} <span class="">{{ auth()->user()->name }} ({{ auth()->user()->email }})</span>
        </div>
    </div>
</x-app-layout>
