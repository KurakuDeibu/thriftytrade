@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-2 bg-white', 'dropdownClasses' => ''])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    'none', 'false' => '',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
};
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    {{-- <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-100 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-50"
            x-transition:leave-end="transform opacity-100 scale-95"
            class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} {{ $dropdownClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-md ring-1 ring-blue ring-opacity-1 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div> --}}


    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform scale-95"
            x-transition:enter-end="transform scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform scale-50"
            x-transition:leave-end="transform scale-95"
            class="absolute z-100 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} {{ $dropdownClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-md ring-1 ring-blue ring-opacity-1 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>


</div>

