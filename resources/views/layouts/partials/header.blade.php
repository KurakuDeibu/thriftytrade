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
            background: left/contain no-repeat;
            transition: all 0.5s ease;
            padding: 5px;
        }

        #logo:hover {
            transform: scale(1.1);

        }

        @media (max-width: 991.98px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
            }

            .navbar-nav .nav-link i {
                margin-right: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .btn-outline-secondary {
                width: 35px;
                height: 35px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<nav class="bg-white shadow-sm navbar sticky-top navbar-expand-lg navbar-light">

    <div class="container d-flex align-items-center">
        {{-- BACK BUTTON --}}
        <button onclick="goBack()" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="Go Back">
            <i class="bi bi-arrow-left"></i>
        </button>

        {{-- LOGO --}}
        <a id="logo" href="/"><img src="{{ asset('img/thriftytrade-logo.png') }}" class="navbar-brand"
                alt="THRIFTYTRADE LOGO"></a>
        <div class="d-flex align-items-center">
            {{-- SEARCH ICON - TOGGLE SEARCH --}}
            <div class="navbar-search-icon me-3" onclick="toggleSearchHeader()" id="search-bar">
                <i class="bi bi-search"></i>
            </div>

            {{-- MOBILE TOGGLE BUTTON --}}
            <button class="m-2 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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



        {{-- COLLAPSE NAVBAR --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="mx-auto navbar-nav">
            </ul>


            @auth
                <div class="py-2"><a href="{{ route('listing.create') }}">
                        <button class="mx-2 btn btn-outline-primary">+ Sell Products</button>
                    </a>
                </div>
            @endauth



            <ul class="navbar-nav">
                <li class="my-2 nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('chat.chat-message') }}">
                            <i class="bi bi-chat"></i>
                            <span class="d-lg-none">Chat</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-chat"></i>
                            <span class="d-lg-none">Chat</span>
                        </a>
                    @endauth
                </li>

                <li class="my-2 nav-item">
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

{{-- Add this script to the existing script section or in a separate script tag --}}
<script>
    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = "/";
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.key === 'ArrowLeft') {
            goBack();
        }
    });
</script>
