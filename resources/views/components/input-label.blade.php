@props([
    'value',
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'block font-medium text-lg text-gray-700']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-600">*</span>
    @endif
</label>
