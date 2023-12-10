<!-- resources/views/walkthrough-sale.blade.php -->

@extends('staff.layout.master')

@section('content')

    <div class="container">
        <h1 class="mt-5 text-center">Walkthrough Sale</h1>

        <!-- Display Product Details Table -->
       <h2 class="mt-4 clearfix">Product Details
    <a href="{{ url('walkin-sales') }}" class="btn btn-success float-right">Walk-in Sales History</a>
</h2>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div id="successModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success!</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
<!-- Ensure jQuery and Bootstrap JS are loaded -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

     <script>
        $(document).ready(function () {
            // Trigger the modal to show
            $('#successModal').modal('show');

            // Trigger the download when the modal is shown
            $('#successModal').on('shown.bs.modal', function () {
                window.location.href = '{{ route('downloadReceipt') }}';
            });
        });
    </script>
@endif


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                       <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                         <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
   <div class="d-flex justify-content-center mt-4">
            {{ $products->links("pagination::bootstrap-4") }}
        </div>
        <!-- Sale Form -->
      <!-- Sale Form -->
<h2 class="mt-4">Sale Form</h2>
<form method="post" action="{{ url('/process-sale') }}" class="mb-5">
    @csrf

    <div id="products-container">
        <!-- Product input fields will be added here dynamically -->
    </div>

    <button type="button" class="btn btn-outline-primary" onclick="addProductField()">Add Product</button>
    <button type="submit" class="btn btn-outline-info">Buy</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Call addProductField() on document ready to show the first set of fields
        addProductField();
    });

    function addProductField() {
        const container = document.getElementById('products-container');

        const productField = document.createElement('div');
        productField.classList.add('product-field');

        productField.innerHTML = `
            <div class="form-group">
                <label for="product_ids[]">Product ID:</label>
                <input type="number" name="product_ids[]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="quantities[]">Quantity:</label>
                <input type="number" name="quantities[]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sizes[]">Size:</label>
                <select name="sizes[]" class="form-control" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
        `;

        container.appendChild(productField);
    }
</script>
<!-- Add this to your HTML file -->
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="purchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="purchaseModalLabel">Purchase Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Product Name:</strong> <span id="productName"></span></p>
        <p><strong>Quantity:</strong> <span id="quantity"></span></p>
        <p><strong>Total Price:</strong> <span id="totalPrice"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection
