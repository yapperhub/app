<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-sky-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-700 focus:bg-sky-700 active:bg-sky-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}
>
    {{ $slot }}

    <div wire:loading>
        <div class="h-4 w-4 animate-spin rounded-full border-4 border-dashed border-sky-600"></div>
    </div>
</button>
