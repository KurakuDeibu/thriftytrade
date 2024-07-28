<ul class="navbar-nav px-2">
    <li class="nav-item">
        {{-- <a class="nav-link active" href="{{ url('/login') }}">Login</a> --}}

        <x-nav-link href="{{ url('login') }}" :active="request()->routeIs('login')">
            {{ __('Login') }}
        </x-nav-link>
    </li>
    <li class="nav-item">
        <x-nav-link href="{{ url('register') }}" :active="request()->routeIs('register')">
            {{ __('Register') }}
        </x-nav-link>
    </li>