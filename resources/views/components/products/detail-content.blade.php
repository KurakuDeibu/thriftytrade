<div class="container mt-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('marketplace') }}">Marketplace</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $marketplaceProducts->prodName }}</li>
        </ol>
    </nav>

    <div class="py-3 d-flex justify-content-between align-items-center">
        <h1><strong>{{ $marketplaceProducts->prodName }}</strong></h1>
        <div class="flex-wrap d-flex justify-content-end">

            <a href="">
            <button class="px-5 btn btn-primary me-2 me-md-5"><i class="bi bi-chat-left-text-fill"></i> Message</button>
            </a>

            <button class="btn btn-outline-primary me-2" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share"></i></button>
            <button class="btn btn-outline-danger me-2" data-toggle="modal" data-target="#reportModal"><i class="fas fa-flag"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $marketplaceProducts->prodImage )}}" class="d-block w-100" alt="{{ $marketplaceProducts->prodName }} image">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('storage/' . $marketplaceProducts->prodImage )}}" class="d-block w-100" alt="{{ $marketplaceProducts->prodName }} image">
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="mb-4 list-group">
                <li class="list-group-item"><strong>Condition:</strong> {{ $marketplaceProducts->prodCondition }}</li>
                <li class="list-group-item"><strong>Category:</strong> {{ $marketplaceProducts->category_id}}</li>
                <li class="list-group-item"><strong>Posted By:</strong> {{ $marketplaceProducts->author->name}}</li>
                <li class="list-group-item"><strong>Price:</strong> ₱{{ $marketplaceProducts->prodPrice }}</li>
                <li class="list-group-item"><strong>Commission Fee:</strong> ₱{{ $marketplaceProducts->prodCommissionFee }}</li>
                {{-- <li class="list-group-item"><strong>Location:</strong> {{ $marketplaceProducts->author->userAddress }}</li> --}}
            </ul>

            <div class="mb-2 card">
                <div class="card-body bg-light">
                    <h5 class="card-title">Description</h5>
                    @if(!Auth::check())
                    {!! \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($marketplaceProducts->prodDescription)), 50) !!}
                    @else
                    {{html_entity_decode(strip_tags($marketplaceProducts->prodDescription))}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share to Socials</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="text-center modal-body">
                <a href="#" class="text-primary h2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-info h2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-danger h2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-success h2"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report this item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <div class="form-group">
                        <label for="reportReason">Reason for report:</label>
                        <select class="form-control" id="reportReason" required="">
                            <option value="">Select a reason</option>
                            <option value="inappropriate">Inappropriate content</option>
                            <option value="spam">Spam</option>
                            <option value="fraud">Fraudulent listing</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="py-3 form-group">
                        <label for="reportDescription">Description:</label>
                        <textarea class="form-control" id="reportDescription" rows="2" required=""></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.see-more').on('click', function(e) {
            e.preventDefault();
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                window.location.href = '{{ route('register') }}';
            } else {
                // Show full description
                $(this).prev().html('{{ $marketplaceProducts->prodDescription }}');
                $(this).remove();
            }
        });
    });
</script>
