<!-- resources/views/staff/walkthrough/walkin-sales-history.blade.php -->

@extends('staff.layout.master')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center">Walk-in Sales History</h1>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Size</th> <!-- New column for Size -->
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($walkinSales as $walkinSale)
                    <tr>
                        <td>{{ $walkinSale->id }}</td>
                        <td>{{ $walkinSale->product_id }}</td>
                        <td>{{ $walkinSale->product->title }}</td>
                      <td>{{ ucfirst($walkinSale->size) }}</td>

 <!-- Display Size -->
                        <td>{{ $walkinSale->quantity }}</td>
                        <td>{{ $walkinSale->total_price }}</td>
                        <td>{{ $walkinSale->created_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Add pagination links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $walkinSales->links("pagination::bootstrap-4") }}
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
