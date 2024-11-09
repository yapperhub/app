<x-app-layout>
    {{--
        <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Dashboard') }}
        </h2>
        </x-slot>
    --}}

    <div class="container mx-auto mt-4 sm:px-6 lg:px-8 text-lg">
        <div class="text-gray-500">
            {{ __("You're logged in as ") }}
            <span class="">{{ auth()->user()->name }} ({{ auth()->user()->email }})</span>
        </div>
    </div>

    <div class="container mx-auto mt-4 sm:px-6 lg:px-8 text-lg">
        <div class="text-gray-700 space-y-2">
            <p>
                Thank you for joining yapper hub! We're excited to have you as part of our community.
            </p>
            <p>
                We’re currently hard at work finalizing the platform, ensuring everything meets our standards for a
                smooth and enjoyable experience. As we continue development, there may be occasional updates or changes
                to the site, and we appreciate your patience and understanding during this time.</p>
            <p>
                You’ll be the first to know as we roll out new features and improvements. In the meantime, feel free to
                reach out with any questions, feedback, or suggestions! on
                <a href="mailto:mail@msamgan.com" class="text-blue-500">mail@msamgan.com</a>
            </p>
            <p>
                Thank you again for your support. We can’t wait to bring you the full experience very soon!
            </p>
        </div>
    </div>
</x-app-layout>
