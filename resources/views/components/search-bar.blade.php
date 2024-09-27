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
         <div class="col-lg-9 px-2">
             <div class="hero-section card py-4 px-4">
                 <h1 class="display-6 mb-1"> THRIFT&TRADE PRODUCTS IN YOUR LOCAL AREAS!</h1>
                     <div class="mt-2">
                         <form class="d-flex search-form" action="" method="GET">

                             <input 
                             class="form-control rounded-0 py-2 me-2" 
                             type="text" 
                             name="query"
                             id="query"
                             value="{{ request()->input('query')}}"
                             placeholder="Search Listings..." aria-label="Search">
                             <button class="btn btn-light" type="submit">Search</button>
                         </form>

                         @include('marketplace.search-results')

                         {{-- FILTER-BUTTONS TO CLOSE UNTA --}}
                         
                        
                     </div>
             </div>
             <!-- END SEARCH BAR -->

             {{-- SEARCH RESULTS----> --}}

            {{-- HERE --}}