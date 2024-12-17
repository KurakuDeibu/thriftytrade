<!-- SIDE-BAR-AUTH -->
<div class="row">
    <div class="mb-4 col-lg-3">
        <aside class="p-3 sidebar">
            <div class="mb-4 text-center">
                {{-- <img src="https://placehold.co/400x400" alt="User Avatar" class="mb-2 user-avatar"> --}}

                <div class="px-2 py-2 mb-2 text-center card bg-light">
                    <div class="flex items-center justify-center py-1 shrink-0 me-2">
                        <img class="object-cover w-12 h-12 mb-1 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }} Profile" />
                    </div>

                    <h3 class="mb-2">Welcome, <strong>{{ Auth::user()->name }}!</strong></h3>
                    {{-- <p class="mb-2">Active Listings: {{ $activeProducts }} </p> --}}

                    <div class="mb-2 card bg-light"><a wire:navigate.hover href="{{ route('dashboard') }}"
                            class="btn btn-outline-primary {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">Dashboard</a>
                    </div>
                    {{-- <div class="mb-2 card bg-light"><a href="/seller-dashboard" class="btn btn-outline-primary">Selling</a></div> --}}
                </div>
            </div>
            @if (Route::currentRouteName() === 'marketplace' || Route::currentRouteName() === 'home')
                {{-- Check if the current route is NOT dashboard --}}
                @include('components.filter') {{-- Include the filter component only if not on dashboard --}}
            @else
                @auth
                    {{-- MANAGE LISTINGS --}}
                    <div class="mb-2 card bg-light"><a wire:navigate.hover href="{{ route('manage-listing') }}"
                            class="btn btn-outline-primary {{ Route::currentRouteName() === 'manage-listing' ? 'active' : '' }}">Manage
                            Listings</a>
                    </div>

                    {{-- MANAGE-OFFERS --}}
                    <div class="mb-2 card bg-light"><a wire:navigate.hover href="{{ route('seller-offers') }}"
                            class="btn btn-outline-primary {{ Route::currentRouteName() === 'seller-offers' ? 'active' : '' }}">Manage
                            Offers</a>
                    </div>

                    {{-- WISHLISTS --}}
                    {{-- <div class="mb-2 card bg-light"><a href="{{ url('/user/wishlists') }}"
                            class="btn btn-outline-primary">My
                            Wishlists</a></div> --}}

                    {{-- TRANSACTIONS --}}
                    <div class="mb-2 card bg -light">
                        <a href="{{ route('user.transactions') }}"
                            class="btn btn-outline-primary {{ Route::currentRouteName() === 'user.transactions' ? 'active' : '' }}">View
                            Transactions</a>
                    </div>

                    {{-- TRANSACTIONS --}}
                    <div class="mb-2 card bg -light">
                        <a wire:navigate.hover href="{{ route('wishlist.index') }}"
                            class="btn btn-outline-primary {{ Route::currentRouteName() === 'wishlist.index' ? 'active' : '' }}">My
                            Wishlists</a>
                    </div>

                    {{-- INSIGHTS --}}
                    <div class="mb-2 card bg-light">
                        <a wire:navigate.hover href="{{ route('profile.user-listing', Auth::user()->id) }}"
                            class="btn btn-outline-primary">Preview Profile</a>
                    </div>

                    {{-- HISTORY --}}
                    <div class="mb-2 card bg-light"><a wire:navigate.hover href="{{ route('chat.index') }}"
                            class="btn btn-outline-primary">Messages</a></div>

                    {{-- REGISTER AS A FINDER --}}
                    @if (Auth::user()->isFinder == false)
                        <div class="mb-2 card bg-light"><a href="{{ route('finder.registration') }}"
                                class="btn btn-outline-primary">Become a Finder</a></div>
                    @endif
                @endauth
            @endif

        </aside>
    </div>
    <!-- END OF SIDE-BAR -->
