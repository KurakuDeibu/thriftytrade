<head>
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        #logo {
            float: left;
            width: 12rem;
            height: 70px;
            background: left/contain no-repeat;
            transition: all 0.5s ease;
            padding: 5px;
        }

        #logo:hover {
            transform: scale(1.05);

        }

        /* Notification Sidebar Styles */
        .notification-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background-color: white;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease-in-out;
            z-index: 1050;
            overflow-y: auto;
        }

        .notification-sidebar.show {
            right: 0;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #f1f3f5;
            display: flex;
            align-items: start;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-icon {
            margin-right: 15px;
            font-size: 24px;
        }

        .notification-content {
            flex-grow: 1;
        }

        .notification-time {
            color: #6c757d;
            font-size: 0.8rem;
            display: block;
            transition: background-color 0.3s ease;

        }

        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        .notification-item.read {
            background-color: #f1f3f5;
            color: #6c757d;
        }

        .notification-overlay.show {
            display: block;
        }

        .read-notifications {
            background-color: #e9ecef;
            padding: 10px;
            margin: 0;
        }


        /* Badge positioning */
        .icon-badge-container {
            position: relative;
            display: inline-block;
        }

        .icon-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            z-index: 1;
            font-size: 0.5rem;
            padding: 0.2rem 0.4rem;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<nav class="bg-white shadow-sm navbar sticky-top navbar-expand-lg navbar-light">

    <div class="container d-flex align-items-center">
        {{-- BACK BUTTON --}}
        <a href="javascript:history.back()" class="me-2 btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Go Back">
            <i class="bi bi-arrow-left"></i>
        </a>

        {{-- LOGO --}}
        <a id="logo" href="/"><img src="{{ asset('img/thriftytrade-logo.png') }}" class="navbar-brand"
                alt="THRIFTYTRADE LOGO"></a>
        <div class="d-flex align-items-center">
            {{-- SEARCH ICON - TOGGLE SEARCH --}}
            <div class="navbar-search-icon me-2" onclick="toggleSearchHeader()" id="search-bar">
                <i class="bi bi-search"></i>
            </div>

            {{-- MOBILE TOGGLE BUTTON --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="btn-collapse" data-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Search Header (Positioned within navbar) -->
        <div class="search-header d-none" id="searchHeader">
            <div class="search-header-container">
                <div class="search-header-input">
                    <form action="{{ route('marketplace') }}" method="GET" class="d-flex">
                        <input type="search" name="query" placeholder="What are you looking for?"
                            class="form-control search-input" id="searchHeaderInput"
                            value="{{ request()->input('query') }}">
                    </form>
                </div>
                <button class="search-header-close" onclick="closeSearchHeader()">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="quick-categories">
                <small class="mb-2 text-muted w-100">Quick Searches:</small>
                @foreach (\App\Models\Category::take(8)->get() as $category)
                    <a href="{{ route('marketplace', ['category' => $category->id]) }}"
                        class="badge bg-light text-dark">
                        {{ $category->categName }}
                    </a>
                @endforeach
            </div>
        </div>



        {{-- btn-collapse NAVBAR --}}
        <div class="btn-collapse navbar-collapse" id="mainNavbar">
            <ul class="mx-auto navbar-nav">
            </ul>


            <ul class="navbar-nav">

                @auth
                    <div class="py-2 d-none d-lg-block">
                        <a href="{{ route('listing.create') }}">
                            <button class="mx-2 btn btn-outline-primary">+ Sell Products</button>
                        </a>
                    </div>
                @endauth

                <li class="my-2">
                    @auth
                        <a class="nav-link" href="{{ route('chat.index') }}">
                            <!-- Chat icon with badge -->
                            <div class="icon-badge-container me-2">
                                <i class="bi bi-chat-dots"></i>
                                <span class="badge bg-primary icon-badge"></span>
                            </div>
                            <span class="d-lg-none">Chat</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-chat"></i>
                            <span class="d-lg-none">Chat</span>
                        </a>
                    @endauth
                </li>


                <li class="my-2 nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" onclick="openNotificationSidebar()">
                        <div class="icon-badge-container me-2">
                            <i class="bi bi-bell"></i>
                            @auth
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="badge bg-danger icon-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
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
                                        <small
                                            class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
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
                                        <a href="{{ $notification->data['link'] }}"
                                            class="text-decoration-none text-dark">
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


                @auth
                    <li class="flex items-center">
                        <a class="px-1" href="{{ route('dashboard') }}">
                            <span class="mr-2 fw-bold">Hi! {{ Auth::user()->name }}</span>
                        </a>
                    </li>
                @endauth

                {{-- Mobile-specific Sell Products Button --}}


                {{-- NAV-BAR --}}
                @auth
                    @include('layouts.partials.header-right-auth')
                @else
                    @include('layouts.partials.header-right-guest')
                @endauth

                @auth
                    <li class="my-2 nav-item d-lg-none btn btn-outline-primary ">
                        <a href="{{ route('listing.create') }}" class="nav-link">
                            + Sell Products
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>



<script>
    function toggleSearchHeader() {
        const searchHeader = document.getElementById('searchHeader');
        const searchInput = document.getElementById('searchHeaderInput');

        // Toggle active class instead of d-none
        searchHeader.classList.toggle('active');

        if (searchHeader.classList.contains('active')) {
            searchHeader.classList.remove('d-none');
            setTimeout(() => {
                searchInput.focus();
            }, 400);
        } else {
            searchHeader.classList.add('d-none');
        }
    }

    function closeSearchHeader() {
        const searchHeader = document.getElementById('searchHeader');
        searchHeader.classList.remove('active');
        searchHeader.classList.add('d-none');
    }

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSearchHeader();
        }
    });

    // Close when clicking outside
    document.addEventListener('click', function(event) {
        const searchHeader = document.getElementById('searchHeader');
        const searchIcon = document.querySelector('.navbar-search-icon');

        if (searchHeader.classList.contains('active') &&
            !searchHeader.contains(event.target) &&
            !searchIcon.contains(event.target)) {
            closeSearchHeader();
        }
    });

    // Prevent closing when interacting with search header
    document.getElementById('searchHeader').addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>

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
