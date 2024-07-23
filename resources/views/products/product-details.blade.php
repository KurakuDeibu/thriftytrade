

    @extends('layouts.app')

    @section('content')

  <div class="container mt-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('marketplace')}}">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">Acer Aspire 5 with Core i5</li>
      </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center py-4">
      <h2>Acer Aspire 5 with Core i5</h2>
      <div>
        <button class="btn btn-outline-primary px-5 mr-5">Message<i class="fas fa-message-alt"></i></button>
        <button class="btn btn-primary mr-1" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share"></i>
          Share</button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#reportModal"><i class="fas fa-flag"></i>
          Report</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://placehold.co/600x400" class="d-block w-100" alt="Acer Aspire 5 front view">
            </div>
            <div class="carousel-item">
              <img src="https://placehold.co/600x400" class="d-block w-100" alt="Acer Aspire 5 side view">
            </div>
            <div class="carousel-item">
              <img src="https://placehold.co/600x400" class="d-block w-100" alt="Acer Aspire 5 keyboard close-up">
            </div>
            <div class="carousel-item">
              <img src="https://placehold.co/600x400" class="d-block w-100" alt="Acer Aspire 5 ports view">
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
        <ul class="list-group mb-4">
          <li class="list-group-item"><strong>Condition:</strong> Lightly Used</li>
          <li class="list-group-item"><strong>Category:</strong> Want a Buyer</li>
          <li class="list-group-item"><strong>Posted By:</strong> Shan Ray</li>
          <li class="list-group-item"><strong>Budget:</strong> ₱20,000</li>
          <li class="list-group-item"><strong>Commission Fee:</strong> ₱1500</li>
          <li class="list-group-item"><strong>Location:</strong> Lapu-Lapu</li>
        </ul>

        <div class="card mb-2">
          <div class="card-body bg-light">
            <h5 class="card-title">Description</h5>
            <p class="card-text">Good as new! Only for 20k, pang gatas lang sa anak...</p>
            <p class="card-text">This Acer Aspire 5 is in excellent condition, barely used. It features a
              powerful Core i5 processor, perfect for everyday tasks and light gaming. The laptop comes
              with its original packaging and all accessories. Don't miss this great deal!</p>
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
        <div class="modal-body text-center">
          <a href="#" class="text-primary"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-info"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-success"><i class="fab fa-whatsapp"></i></a>
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
            <div class="form-group">
              <label for="reportDescription">Description:</label>
              <textarea class="form-control" id="reportDescription" rows="2" required=""></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Report</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('reportForm').addEventListener('submit', function (e) {
      e.preventDefault();
      alert('Report submitted. Thank you for your feedback.');
      $('#reportModal').modal('hide');
    });
  </script>

</body>

</html>