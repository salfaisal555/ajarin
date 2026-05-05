@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-bold text-gray-700 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
