@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-weight-normal fs-6']) }}>
    {{ $value ?? $slot }}
</label>
