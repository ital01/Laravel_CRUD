@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-weight-normal fs-6 text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
