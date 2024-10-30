{{-- components/alert-toast.blade.php --}}
@props([
    'type' => 'success',
    'message',
    'position' => 'top-end', // top-end, top-start, bottom-end, bottom-start
    'duration' => 5000,
])

@php
    // Define all possible alert types and their corresponding styles
    $alertTypes = [
        'success' => [
            'icon' => 'bi-check-circle-fill',
            'bgClass' => 'bg-success',
            'textClass' => 'text-white',
        ],
        'error' => [
            'icon' => 'bi-exclamation-circle-fill',
            'bgClass' => 'bg-danger',
            'textClass' => 'text-white',
        ],
        'warning' => [
            'icon' => 'bi-exclamation-triangle-fill',
            'bgClass' => 'bg-warning',
            'textClass' => 'text-dark',
        ],
        'info' => [
            'icon' => 'bi-info-circle-fill',
            'bgClass' => 'bg-info',
            'textClass' => 'text-white',
        ],
        'primary' => [
            'icon' => 'bi-info-circle-fill',
            'bgClass' => 'bg-primary',
            'textClass' => 'text-white',
        ],
        'secondary' => [
            'icon' => 'bi-info-circle-fill',
            'bgClass' => 'bg-secondary',
            'textClass' => 'text-white',
        ],
        'dark' => [
            'icon' => 'bi-info-circle-fill',
            'bgClass' => 'bg-dark',
            'textClass' => 'text-white',
        ],
        'light' => [
            'icon' => 'bi-info-circle-fill',
            'bgClass' => 'bg-light',
            'textClass' => 'text-dark',
        ],
    ];

    // Get the alert configuration or default to success
    $alertConfig = $alertTypes[$type] ?? $alertTypes['success'];

    // Position classes
    $positionClasses = [
        'top-end' => 'top-0 end-0',
        'top-start' => 'top-0 start-0',
        'bottom-end' => 'bottom-0 end-0',
        'bottom-start' => 'bottom-0 start-0',
    ];

    $positionClass = $positionClasses[$position] ?? $positionClasses['top-end'];
@endphp

<div id="{{ $type }}Alert" class="p-3 position-fixed {{ $positionClass }}"
    style="z-index: 1050; transform: translateX(100%); transition: transform 0.3s ease-in-out;"
    data-duration="{{ $duration }}">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header {{ $alertConfig['bgClass'] }} {{ $alertConfig['textClass'] }}">
            <i class="bi {{ $alertConfig['icon'] }} me-2"></i>
            <strong class="me-auto">{{ ucfirst($type) }}</strong>
            <small>Just now</small>
            <button type="button"
                class="btn-close {{ $alertConfig['textClass'] === 'text-white' ? 'btn-close-white' : '' }}"
                data-bs-dismiss="toast" aria-label="Close">
            </button>
        </div>
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>
