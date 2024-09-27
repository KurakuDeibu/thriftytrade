<style>
    body {
        background-color: #f8f9fa;
        width: 100vw;
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
</style>

<nav class="bg-white shadow-sm navbar sticky-top navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" id="logo" href="/"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="mx-auto navbar-nav">
                {{-- <li class="nav-item">
                        <a class="nav-link" href= "{{url('/marketplace')}}">
                            <i class="bi bi-shop"></i> Marketplace
                        </a>
                    </li> --}}
                @auth

                    {{-- <li class="nav-item">
                        <x-nav-link href="{{ url('marketplace') }}" :active="request()->routeIs('marketplace')"><i class="bi bi-shop">
                                {{ __('Marketplace') }}</i>
                        </x-nav-link>
                    </li> --}}

                    {{-- <li class="nav-item">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"><i class="bi bi-heart">
                                {{ __('Wishlist') }}</i>
                        </x-nav-link>
                    </li> --}}
                @endauth

            </ul>

            @auth
                <div class="py-2"><a wire:navigate href="/create/listing">
                        <button class="mx-2 btn btn-outline-primary">+ Sell Products</button>
                    </a>
                </div>
            @endauth

            <ul class="navbar-nav">
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="/auth/chatui">
                        @endauth
                        @guest
                            <a class="nav-link" href="/guest/chatui">
                            @endguest
                            <i class="bi bi-chat"></i>
                        </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/notifications">
                        <i class="bi bi-bell"></i>
                    </a>
                </li>

                @auth
                <li class="flex items-center">
                    <a class="px-1" href="/dashboard">
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
