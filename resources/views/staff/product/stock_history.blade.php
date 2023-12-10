@extends('staff.layout.master')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">Stock History - {{ $product->title }}</h1>
        </div>

        @if ($stockHistory->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="thead-blue">
                        <tr>
                            <th>Quantity Added</th>
                            <th>Size</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockHistory as $history)
                            <tr>
                                <td>{{ $history->quantity }}</td>
                                <td>{{ $history->size }}</td>
                                <td>{{ Carbon\Carbon::parse($history->created_at)->format('F j, Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $stockHistory->links("pagination::bootstrap-4") }}
            </div>
        @else
            <p>No stock history found for this product.</p>
        @endif
    </div>
@endsection
