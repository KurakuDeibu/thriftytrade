<style>
   <style>
    body,
    html {
      background-color: #f0f2f5;
    }

    .navbar-brand {
      font-weight: bold;
      color: #4267b2 !important;

    }
    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .nav-link-custom:hover::after {
      content: '';
      display: block;
      border-bottom: 2px solid #4267B2;
      width: 100%;
      position: absolute;
      bottom: 0;
      left: 0;
    }

    .stat-card-custom {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .status-active {
      color: #42b72a;
    }

    .status-sold {
      color: #1877F2;
    }

</style>




@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">

            @auth
                @include('layouts.side-bar.side-bar-auth')
            @endauth

            @guest
                @include('layouts.side-bar.side-bar-guest')
            @endguest


            @include('components.search-bar')
            <!-- SIDE-BAR CONTAINER-->

            <!-- CONTENT -->
            <main>

                <!-- CONTENT -->
                <div class="container mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="navbar-brand">{{ Auth::user()->name }}'s' Dashboard</h1>
                        {{-- <button class="btn btn-outline-primary"> Manage Listing</button> --}}
                    </div>

                    {{-- @foreach ($featuredProducts as $products) --}}

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="bg-white p-3 rounded stat-card-custom">
                                <div class="text-muted">Active Listings</div>
                                <div class="h4">5</div>
                            </div>
                        </div>
                                                
                    {{-- @endforeach --}}

                        <div class="col-md-3 mb-3">
                            <div class="bg-white p-3 rounded stat-card-custom">
                                <div class="text-muted">Items Sold</div>
                                <div class="h4">12</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white p-3 rounded stat-card-custom">
                                <div class="text-muted">Total Earnings</div>
                                <div class="h4">₱250
                                    {{-- {{Auth::user()->products->sum('price')}} --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white p-3 rounded stat-card-custom">
                                <div class="text-muted">Average Rating</div>
                                <div class="h4">4.8 <span class="h6">/ 5</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">Your Listings</h2>
                            <select class="custom-select w-auto">
                                <option>All Listings</option>
                                <option>Active</option>
                                <option>Sold</option>
                            </select>
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Date Listed</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Vintage Lamp</td>
                                    <td>₱250</td>
                                    <td>May 15, 2024</td>
                                    <td><span class="status-active">Active</span></td>
                                    <td>
                                        <button class="btn btn-outline-primary">Edit</button>
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mountain Bike</td>
                                    <td>₱250</td>
                                    <td>May 10, 2024</td>
                                    <td><span class="status-sold">Sold</span></td>
                                    <td>
                                        <button class="btn btn-primary">View Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Wooden Bookshelf</td>
                                    <td>₱250</td>
                                    <td>May 18, 2024</td>
                                    <td><span class="status-active">Active</span></td>
                                    <td>
                                        <button class="btn btn-outline-primary">Edit</button>
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Coffee Maker</td>
                                    <td>₱250</td>
                                    <td>May 20, 2024</td>
                                    <td><span class="status-active">Active</span></td>
                                    <td>
                                        <button class="btn btn-outline-primary">Edit</button>
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Indoor Plant</td>
                                    <td>₱250</td>
                                    <td>May 22, 2024</td>
                                    <td><span class="status-active">Active</span></td>
                                    <td>
                                        <button class="btn btn-outline-primary">Edit</button>
                                        <button class="btn btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    </main>
    <!-- END OF CONTENT -->
    {{-- @include('components.pagination') --}}
    </div>
@endsection

{{-- <script>
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
    </script> --}}
