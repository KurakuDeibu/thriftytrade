<!-- SIDE-BAR-START -->
<div class="row">
<div class="col-lg-3 mb-4">

    <aside class="sidebar p-3">
        <div class="text-center mb-4">
            {{-- <img src="https://placehold.co/400x400" alt="User Avatar" class="user-avatar mb-2"> --}}
          
            <div class="card bg-light py-2 text-center mb-2 px-2">
            <div class="shrink-0 me-2 flex justify-center items-center py-1">
                <img class="h-12 w-12 rounded-full object-cover mb-1" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }} Profile" />
            </div>

            <h3 class="mb-2">Welcome, <strong>{{ Auth::user()->name }}!</strong></h3>
        {{-- <p class="mb-2">Active Listings: {{$productCount}} </p> --}}
        <p class="mb-2">Active Listings: 5 </p>
            <div class="card bg-light mb-2"><a href="{{url('/dashboard')}}" class="btn btn-outline-primary">Dashboard</a></div> 
            {{-- <div class="card bg-light mb-2"><a href="/seller-dashboard" class="btn btn-outline-primary">Selling</a></div> --}}
        </div>
        </div>

        @auth
            
        <div class="card bg-light mb-2"><a href="{{url('/managelisting')}}" class="btn btn-outline-primary">Manage Listings</a></div>
        @endauth

        
        @if (Route::has('/marketplace'))
        
        @endif
        
        @include('components.filter')

    </aside>
</div>
<!-- END OF SIDE-BAR -->
