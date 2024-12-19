<li class="my-2 nav-item dropdown">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
        onclick="openNotificationSidebar()">
        <div class="icon-badge-container me-2">
            <i class="bi bi-bell"></i>
            @auth
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge bg-danger icon-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
                @endif
            @endauth

        </div>
        <span class="d-lg-none">Notifications</span>
    </a>


    <!-- Notification Sidebar -->
    <div class="notification-overlay" id="notificationOverlay"></div>
    <div class="notification-sidebar" id="notificationSidebar">
        <div class="notification-header">
            <h5 class="mb-0">Notifications</h5>
            @auth
                <button class="text-sm btn btn-link" id="markAllReadBtn">Mark all as read</button>
            @endauth

            <button class="btn btn-link text-dark" onclick="closeNotificationSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        @auth

            {{-- New Message Notification --}}
            @foreach (auth()->user()->unreadNotifications as $notification)
                <a href="{{ $notification->data['link'] }}"
                    class="text-decoration-none text-dark notification-item border-bottom"
                    data-id="{{ $notification->id }}">
                    <div class="notification-icon text-success">
                        <i class="bi bi-bell"></i>
                    </div>
                    <div class="notification-content">
                        <strong>Notification</strong>
                        <p class="mb-1">{{ $notification->data['message'] }}</p>
                        <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </a>
            @endforeach
            @if (auth()->user()->notifications()->unread()->count() === 0)
                <div class="p-2 text-center notification-item text-muted">
                    No new notifications.
                </div>
            @endif
        @else
            <a href="{{ route('login') }}" class="p-2 text-center notification-item text-muted">
                Login to view your notifications.
            </a>
        @endauth

        {{-- Read Notifications --}}
        <div class="read-notifications">

            @auth

                @foreach (auth()->user()->readNotifications as $notification)
                    <div class="p-2 notification-item border-bottom" data-id="{{ $notification->id }}">
                        <a href="{{ $notification->data['link'] }}" class="text-decoration-none text-dark">
                            <i class="bi bi-bell"></i>
                            {{ $notification->data['message'] }}
                        </a>
                        <span class="text-sm text-muted">Read at:
                            {{ $notification->read_at->diffForHumans() }}</span>
                    </div>
                @endforeach
                @if (auth()->user()->notifications()->whereNotNull('read_at')->count() === 0)
                    <div class="p-2 text-center notification-item text-muted">
                        No read notifications
                    </div>
                @endif
            @endauth

        </div>
    </div>
</li>


<script>
    function openNotificationSidebar() {
        document.getElementById('notificationSidebar').classList.add('show');
        document.getElementById('notificationOverlay').classList.add('show');
    }

    function closeNotificationSidebar() {
        document.getElementById('notificationSidebar').classList.remove('show');
        document.getElementById('notificationOverlay').classList.remove('show');
    }

    // Close sidebar when clicking overlay
    document.getElementById('notificationOverlay').addEventListener('click', closeNotificationSidebar);

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeNotificationSidebar();
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark individual notification as read
        document.querySelectorAll('.mark-as-read').forEach(function(notification) {
            notification.addEventListener('click', function(event) {
                event.preventDefault();
                const notificationId = this.closest('.notification-item').dataset.id;

                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        this.closest('.notification-item').classList.add(
                            'read');
                    }
                });
            });
        });

        // Mark all notifications as read
        document.getElementById('markAllReadBtn').addEventListener('click', function() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    document.querySelectorAll('.notification-item').forEach(function(item) {
                        item.classList.add('read'); // class to style as read
                    });
                }
            });
        });
    });
</script>
