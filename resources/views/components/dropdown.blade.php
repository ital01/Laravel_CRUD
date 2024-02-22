@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-light'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'text-start';
        break;
    case 'top':
        $alignmentClasses = 'align-items-start';
        break;
    case 'right':
    default:
        $alignmentClasses = 'text-end';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="position-relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="position-absolute z-index-50 mt-2 {{ $width }} rounded shadow {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded border ring-1 ring-dark ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
