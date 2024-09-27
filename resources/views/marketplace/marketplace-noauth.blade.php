<style>
    body {
        background-color: #f8f9fa;
    }

    .navbar-brand {
        font-weight: bold;
        color: #4267B2 !important;
    }

    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }

    .dashboard-btn {
        background-color: #4267B2;
        color: white;
    }

    .item-card {
        transition: transform 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .item-image {
        height: 200px;
        object-fit: cover;
    }

    .item-title {
        font-weight: bold;
    }

    .item-price {
        color: #4267B2;
        font-weight: 500;
    }
</style>

            <div class="row">

                @extends('layouts.app')
                @section('content')

                    @include('layouts.side-bar.side-bar-guest')
                    @include('components.search-bar')
                    <!-- SIDE-BAR CONTAINER-->

                    <!-- CONTENT -->
                    <main>
                        <div class="py-2 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Vintage Lamp" class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Vintage Lamp</h5>
                                        <p class="card-text item-price">$45</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Mountain Bike"
                                        class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Mountain Bike</h5>
                                        <p class="card-text item-price">$120</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Wooden Bookshelf"
                                        class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Wooden Bookshelf</h5>
                                        <p class="card-text item-price">$80</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Acoustic Guitar"
                                        class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Acoustic Guitar</h5>
                                        <p class="card-text item-price">$150</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Coffee Maker"
                                        class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Coffee Maker</h5>
                                        <p class="card-text item-price">$35</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 item-card">
                                    <img src="https://placehold.co/400x400" alt="Indoor Plant"
                                        class="card-img-top item-image">
                                    <div class="card-body">
                                        <h5 class="card-title item-title">Indoor Plant</h5>
                                        <p class="card-text item-price">$25</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <!-- END OF CONTENT -->
                    {{-- @include('components.pagination') --}}
                </div>
            @endsection

    <script>
        // JavaScript for enhancing user interaction
        document.querySelector('.btn-new-listing').addEventListener('click', function() {
            alert('Opening new listing form...');
        });

        document.querySelectorAll('.item-card').forEach(card => {
            card.addEventListener('click', function() {
                const itemTitle = this.querySelector('.item-title').textContent;
                alert('View details for ' + itemTitle);
            });
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const location = document.getElementById('location').value;
            const category = document.getElementById('category').value;
            const condition = document.getElementById('condition').value;
            alert(`Applying filters: Location - ${location}, Category - ${category}, Condition - ${condition}`);
        });
    </script>
