<!-- resources/views/backend/product/inventory.blade.php -->

@extends('staff.layout.master')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">Product Inventory</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <input type="text" class="form-control" id="productNameSearch" placeholder="Search by Product Name">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead class="thead-blue">
                    <tr>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Sold Stock</th>
                        <th>Add Stock</th>
                        <th>Added Stock</th>
                        <th>Stock Added Date</th>
                        <th>Small</th>
                        <th>Medium</th>
                        <th>Large</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->sold_stock }}</td>
                            <td>
                                <form method="POST" action="{{ route('product.addStock', ['id' => $product->id]) }}" id="addStockForm_{{ $product->id }}">
                                    @csrf
                                    @method('put')
                                    <div class="input-group">
                                        <input type="text" name="stock_info" class="form-control" placeholder="e.g., 2, Small" aria-describedby="button-addon">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" onclick="addStock({{ $product->id }})">Add Stock</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="stock_added_at" id="stock_added_at_{{ $product->id }}" value="">
                                </form>
                            </td>
                            <td class="text-center">
                                {{ $product->added_stock_history }}
                                @if($product->added_stock_history > 0)
                                    <br>
                                    <a href="{{ route('product.stockHistory', ['id' => $product->id]) }}" class="d-block btn btn-info btn-sm mt-2">View History</a>
                                @endif
                            </td>
                            <td>
                                {{ $product->stock_added_at ? Carbon\Carbon::parse($product->stock_added_at)->format('Y-m-d H:i:s') : 'N/A' }}
                            </td>
                            <td>{{ $product->stock_small }}</td>
                            <td>{{ $product->stock_medium }}</td>
                            <td>{{ $product->stock_large }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No products found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links("pagination::bootstrap-4") }}
        </div>
    </div>

    <script>
        function addStock(productId) {
            var now = new Date();
            var formattedDate = now.toISOString().slice(0, 19).replace("T", " ");
            document.getElementById("stock_added_at_" + productId).value = formattedDate;
            document.getElementById("addStockForm_" + productId).submit();
        }

        document.getElementById('productNameSearch').addEventListener('input', function () {
            var filter, table, tr, td, i, txtValue;
            filter = this.value.toUpperCase();
            table = document.querySelector('.table');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td')[0]; // Index 0 corresponds to the Product Name column

                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        });
    </script>
@endsection
