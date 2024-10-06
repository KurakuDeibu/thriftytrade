<style>
    .navbar-brand {
        font-weight: bold;
        color: #4267b2 !important;
    }

    .stat-card-custom {
        border: solid 1px rgb(38, 41, 237);
        box-shadow: 5px 5px 10px rgba(88, 122, 255, 0.1);
    }

    .status-active {
        color: #42b72a;
    }

    .status-sold {
        color: #1877F2;
    }

    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">

            @auth
                @include('layouts.side-bar.side-bar-auth')
            @else
                @include('layouts.side-bar.side-bar-guest')
            @endauth

            {{-- @include('components.search-bar') --}}
            <!-- SIDE-BAR CONTAINER-->

            <div class="py-2 col-md-9 border-2 border-white">
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
                                    <div class="h4">2</div>
                                </div>
                            </div>

                            {{-- @endforeach --}}

                            <div class="col-md-3 mb-3">
                                <div class="bg-white p-3 rounded stat-card-custom">
                                    <div class="text-muted">Items Sold</div>
                                    <div class="h4">1</div>
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



                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Condition
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Category
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Price
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userProducts as $product)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $product->prodName }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $product->prodCondition }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $product->category->categName }}
                                        </td>
                                        <td class="px-6 py-4">
                                            ₱{{ $product->prodPrice }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
</div>

                    </div>
            </div>
        </div>
    </div>
    </main>
    </div>
    <!-- END OF CONTENT -->
    {{-- @include('components.pagination') --}}
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
