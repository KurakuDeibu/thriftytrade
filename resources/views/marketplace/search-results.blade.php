<div class="container">
    @if(request()->filled('query'))
        <h1>Search Results</h1>
        <p><span class="fw-bold">{{ $marketplaceProducts->total() }} </span> result(s) for ' {{ request()->input('query') }} '</p>
    @else
    
    @endif
</div>