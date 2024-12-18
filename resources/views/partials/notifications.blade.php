@forelse($notifications as $notification)
    <a href="{{ $notification->data['link'] ?? '#' }}" class="text-decoration-none text-dark notification-item"
        data-notification-id="{{ $notification->id }}">
        <div class="notification-icon" style="color: {{ $notification->data['icon_color'] ?? 'text-primary' }}">
            <i class="{{ $notification->data['icon'] ?? 'bi bi-bell' }}"></i>
        </div>
        <div class="notification-content">
            <strong>{{ $notification->data['type'] ?? 'Notification' }}</strong>
            <p class="mb-1">{{ $notification->data['message'] ?? 'New notification' }}</p>
            <small class="notification-time">
                {{ $notification->created_at->diffForHumans() }}
            </small>
        </div>
    </a>
@empty
    <div class="py-4 text-center text-muted">
        No new notifications
    </div>
@endforelse
