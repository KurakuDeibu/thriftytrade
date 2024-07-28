<style>
    .auth-prompt {
        background-color: #e9ecef;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="row">
    <div class="col-lg-3 mb-4">
        <aside class="sidebar p-3">
            <div class="auth-prompt">
                <h4>Ready to start?</h4>
                <p class="mb-2">Sign up or log in to access all features and start your <span class="text-primary">Thrifty Activity!</span></p>
                <a href="{{ url('/register') }}" class="btn btn-primary mb-2">Register</a>
                <a href="{{ url('/login') }}" class="btn btn-outline-primary mb-2">Login</a>
            </div>

            <div>
                <h4>Browse Categories</h4>
                <ul class="list-group mt-2">
                    <li class="list-group-item"><a href="/category/" class="text-decoration-none">Want a Buyer</a></li>
                    <li class="list-group-item"><a href="/category/" class="text-decoration-none">Want a Seller</a></li>
                    </li>
                    <li class="list-group-item"><a href="/category/" class="text-decoration-none">Featured</a></li>
                    <li class="list-group-item"><a href="/category/" class="text-decoration-none">Vehicles</a></li>
                    <li class="list-group-item"><a href="/categories" class="text-decoration-none">Others</a></li>
                </ul>
            </div>

        </aside>
    </div>
