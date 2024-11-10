@props([
    'disabled' => false,
    'name' => '',
])

<input
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm']) }}
/>

@error($name)
    <x-input-error :messages="$errors->first($name)" />
@enderror
