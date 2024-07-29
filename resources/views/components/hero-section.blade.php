<style>
    .hero-section {
        background: linear-gradient(rgba(11, 66, 177, 0.8), rgba(66, 103, 178, 0.9)), url('img/hero-img.png');
        background-size: cover;
        color: white;
        padding: 60px 0;
        margin-bottom: 15px;
    }
</style>
{{-- HERO SECTION --}}
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-3">Welcome to <span class="fw-bold">THRIFTYTRADE</span></h1>
        <p class="lead mb-4">Buy and sell secondhand items in your local community</p>

        @guest
            <a href="{{ '/register' }}" class="btn btn-light btn-lg mt-2">Join Now</a>
        @endguest

        @auth
            <a href="{{ '/marketplace' }}" class="btn btn-light btn-lg mt-2">Start your Thrifty Activity!</a>
        @endauth

        {{-- <div class="search-bar mt-4"> --}}

            {{-- <form class="d-flex">

                <input class="form-control me-2" type="search" placeholder="Search for listings..."
                    aria-label="Search">
                <button class="btn btn-light" type="submit">Search</button>
            </form> --}}

        {{-- </div> --}}

    </div>
</div>
{{-- END HERO SECTION --}}
