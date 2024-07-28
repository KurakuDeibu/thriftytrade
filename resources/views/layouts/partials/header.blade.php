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
        /* Remove default underline */
    }

    .hoverlink::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        /* Adjust to control the gap between text and underline */
        height: 1px;
        /* Same as your original border-bottom width */
        width: 0%;
        /* Initial width of the underline */
        background-color: #4267B2;
        transition: width 0.3s ease;
        /* Smooth transition effect */
    }

    .hoverlink:hover::after {
        width: 100%;
        /* Full width on hover */
    }
#logo {
    float: left;
    width: 12rem;
    height: 70px;
    background: url("img/thriftytrade-logo.png") left/contain no-repeat;
    transition: all 0.5s ease;
}

#logo:hover {
    background: url("img/thriftytrade-logo.png") left/contain no-repeat;
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

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" id="logo" href="/"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                {{-- <li class="nav-item">
                        <a class="nav-link" href= "{{url('/marketplace')}}">
                            <i class="bi bi-shop"></i> Marketplace
                        </a>
                    </li> --}}
                <li class="nav-item">
                    <x-nav-link href="{{ url('marketplace') }}" :active="request()->routeIs('marketplace')"><i class="bi bi-shop">
                        {{ __('Marketplace') }}</i>
                    </x-nav-link>
                </li>

                @auth
                    <li class="nav-item">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"><i class="bi bi-heart">
                            {{ __('Wishlist') }}</i>
                        </x-nav-link>
                    </li>
                @endauth

            </ul>

            @auth
                <div class="py-2"><a wire:navigate href="/create/listing">
                        <button class="btn btn-outline-primary mx-2">+ New Listing</button>
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
