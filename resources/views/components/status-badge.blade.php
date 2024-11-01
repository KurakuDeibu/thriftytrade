@props(['status'])

@php
    $badges = [
        'Available' => [
            'class' => 'bg-success',
            'icon' => 'fas fa-check-circle',
        ],
        'Negotiable' => [
            'class' => 'bg-warning',
            'icon' => 'fas fa-handshake',
        ],
        'Pending' => [
            'class' => 'bg-primary',
            'icon' => 'fas fa-clock',
        ],
        'Sold' => [
            'class' => 'bg-secondary',
            'icon' => 'fas fa-tag',
        ],
        'Rush' => [
            'class' => 'bg-danger',
            'icon' => 'fas fa-money-bill-wave',
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
