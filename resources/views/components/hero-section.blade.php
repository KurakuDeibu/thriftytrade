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
        <p class="mb-4 lead">Buy and sell secondhand items in your local community</p>

        @guest
            <a href="{{ '/register' }}" class="mt-2 btn btn-light btn-lg">Join Now</a>
        @endguest

        @auth
            <a href="{{ '/marketplace' }}" class="mt-2 btn btn-light btn-lg">Start your Thrifty
                Activity!</a>
        @endauth

    </div>
</div>
{{-- END HERO SECTION --}}
