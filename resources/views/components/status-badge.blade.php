@props(['status'])

@php
    $badges = [
        'Available' => [
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle',
        ],
        'Pending' => [
            'class' => 'bg-warning',
            'icon' => 'fas fa-clock',
        ],
        'Sold' => [
            'class' => 'bg-secondary',
            'icon' => 'fas fa-tag',
        ],
    ];

    $badgeInfo = $badges[$status] ?? [
        'class' => 'bg-secondary',
        'icon' => 'fas fa-question',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $badgeInfo['class']]) }}>
    <i class="{{ $badgeInfo['icon'] }}"></i>
    {{ $status }}
</span>
