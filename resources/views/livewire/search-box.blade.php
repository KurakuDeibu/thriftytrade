<style>
    .hero-section {
        background: linear-gradient(rgba(11, 66, 177, 0.8), rgba(66, 103, 178, 0.9)), url('img/hero-img.png');
        background-size: cover;
        color: white;
        padding: 60px 0;
        margin-bottom: 15px;
    }
</style>

<!-- SEARCH-BAR -->

<!-- END SEARCH BAR -->


    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div x-data="{
    query: ''
    }" id="search-box" class="col-lg-9 px-2">
        <div class="hero-section card py-4 px-4">
            <h1 class="display-6 mb-1"> THRIFT&TRADE PRODUCTS IN YOUR LOCAL AREAS!</h1>
            <div class="mt-2">
                <form class="d-flex">
                    <input x-model="query"   
                    class="form-control rounded-0 py-2 me-2" type="text" placeholder="Search...">
                    <x-button x-on:click="$dispath('search',{
                        search : query
                    })">Search</x-button>
                </form>

                {{-- FILTER-BUTTONS TO CLOSE UNTA --}}
            </div>
        </div>
    </div>