<head>
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .hoverlink {
            position: relative;
            display: inline-block;
            text-decoration: none;
        }

        .hoverlink::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            height: 1px;
            width: 0%;
            background-color: #4267B2;
            transition: width 0.3s ease;
        }

        .hoverlink:hover::after {
            width: 100%;
            /* Full width on hover */
        }

        #logo {
            float: left;
            width: 12rem;
            height: 70px;
            background: url("{{ asset('img/thriftytrade-logo.png') }}") left/contain no-repeat;
            transition: all 0.5s ease;
        }

        #logo:hover {
            background: url("{{ asset('img/thriftytrade-logo.png') }}") left/contain no-repeat;
            transform: scale(1.2);
        }

        @keyframes logoAnimation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 991.98px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
            }

            .navbar-nav .nav-link i {
                margin-right: 0.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<nav class="bg-white shadow-sm navbar sticky-top navbar-expand-lg navbar-light">
    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand" id="logo" href="/"></a>
        <div class="navbar-nav-wrapper d-flex align-items-center">
            {{-- SEARCH ICON - TOGGLE SEARCH --}}
            <div class="navbar-search-icon me-3" onclick="toggleSearchHeader()" id="search-bar">
                <i class="bi bi-search"></i>
            </div>

            {{-- MOBILE TOGGLE BUTTON --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>


        <!-- Search Header (Positioned within navbar) -->
        <div class="search-header" id="searchHeader">
            <div class="search-header-container">
                <div class="search-header-input">
                    <form action="{{ route('marketplace') }}" method="GET" class="d-flex">
                        <input type="search" name="query" placeholder="What are you looking for?"
                            class="form-control search-input" id="searchHeaderInput"
                            value="{{ request()->input('query') }}">

                        <!-- Hidden inputs for preserving current filters -->
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        @if (request('condition'))
                            <input type="hidden" name="condition" value="{{ request('condition') }}">
                        @endif

                        @if (request('featured'))
                            <input type="hidden" name="featured" value="{{ request('featured') }}">
                        @endif

                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
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

        {{-- COLLAPSE NAVBAR --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="mx-auto navbar-nav">
                {{-- <li class="nav-item">
                        <a class="nav-link" href= "{{url('/marketplace')}}">
                            <i class="bi bi-shop"></i> Marketplace
                        </a>
                    </li> --}}
                {{-- @auth

                    <li class="nav-item">
                        <x-nav-link href="{{ url('marketplace') }}" :active="request()->routeIs('marketplace')"><i class="bi bi-shop">
                                {{ __('Marketplace') }}</i>
                        </x-nav-link>
                    </li>

                    <li class="nav-item">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"><i class="bi bi-heart">
                                {{ __('Wishlist') }}</i>
                        </x-nav-link>
                    </li>
                @endauth --}}

            </ul>


            @auth
                <div class="py-2"><a href="{{ route('listing.create') }}">
                        <button class="mx-2 btn btn-outline-primary">+ Sell Products</button>
                    </a>
                </div>
            @endauth



            <ul class="navbar-nav">
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('chat.chat-message') }}" id="chat-icon">
                        @endauth
                        @guest
                            <a class="nav-link" href="{{ route('chat.chat-message') }}">
                            @endguest
                            <i class="bi bi-chat"></i>
                            <span class="d-lg-none">Chat</span>
                        </a>
                </li>

                <li class="nav-item" id="notification-icon">
                    <a class="nav-link" href="/notifications">
                        <i class="bi bi-bell"></i>
                        <span class="d-lg-none">Notifications</span>
                    </a>
                </li>


                @auth
                    <li class="flex items-center">
                        <a class="px-1" href="{{ route('dashboard') }}">
                            <span class="mr-2 fw-bold">Hi! {{ Auth::user()->name }}</span>
                        </a>
                    </li>
                @endauth

            </ul>

            {{-- NAV-BAR --}}
            @auth
                @include('layouts.partials.header-right-auth')
            @else
                @include('layouts.partials.header-right-guest')
            @endauth

            </ul>
        </div>
    </div>
</nav>

<script>
    function toggleSearchHeader() {
        const searchHeader = document.getElementById('searchHeader');
        const searchInput = document.getElementById('searchHeaderInput');

        searchHeader.classList.toggle('active');

        if (searchHeader.classList.contains('active')) {
            setTimeout(() => {
                searchInput.focus();
            }, 400);
        }
    }

    function closeSearchHeader() {
        const searchHeader = document.getElementById('searchHeader');
        searchHeader.classList.remove('active');
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
