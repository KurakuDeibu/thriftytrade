<!-- SIDE-BAR-START -->
<div class="row">
<div class="col-lg-3 mb-4">

    <aside class="sidebar p-3">
        <div class="text-center mb-4">
            {{-- <img src="https://placehold.co/400x400" alt="User Avatar" class="user-avatar mb-2"> --}}

            <div class="shrink-0 me-2 flex justify-center items-center py-1">
                <img class="h-30 w-45 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </div>

            <h3>Welcome, <strong>{{ Auth::user()->name }}!</strong></h3>
            <p>Active Listings: 5</p>
            <div class="card bg-light mb-2"><a href="{{url('/dashboard')}}" class="btn btn-outline-primary">Dashboard</a></div>
            {{-- <div class="card bg-light mb-2"><a href="/seller-dashboard" class="btn btn-outline-primary">Selling</a></div> --}}
        </div>
        <div class="card bg-light py-2 text-center mb-2">
            <h4>Your Stats</h4>
            <p>Items Sold: 12</p>
            <p>Earnings: ₱350</p>
        </div>



        @include('components.filter')

    </aside>
</div>
<!-- END OF SIDE-BAR -->
