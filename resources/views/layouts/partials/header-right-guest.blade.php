<ul class="px-2 navbar-nav">
    <li class="nav-item">
        <x-nav-link href="{{ url('login') }}" :active="request()->routeIs('login')">
            {{ __('Login') }}
        </x-nav-link>
    </li>
</ul>
