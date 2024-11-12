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
    <div class="mb-4 col-lg-3">
        <aside class="p-3 sidebar">
            <div class="auth-prompt">
                <h4>Ready to start?</h4>
                <p class="mb-2">Sign up or log in to access all features and start your <span
                        class="text-primary">Thrifty Activity!</span></p>
                <a href="{{ url('/register') }}" class="mb-2 btn btn-primary">Register</a>
                <a href="{{ url('/login') }}" class="mb-2 btn btn-outline-primary">Login</a>
            </div>

            <div>
                <h4>Browse Categories</h4>
                <ul class="mt-2 list-group">
                    @foreach (\App\Models\Category::all() as $category)
                        <li wire:model="category" class="list-group-item">
                            <a href="{{ route('marketplace', ['category' => $category->id]) }}"
                                class="text-decoration-none">
                                {{ $category->categName }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
