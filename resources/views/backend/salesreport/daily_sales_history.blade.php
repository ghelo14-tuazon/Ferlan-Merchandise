@extends('backend.layouts.master')

@section('content')
    <div class="card-body">
        <h4 class="text-center mb-4">Daily Sales History</h4>

        @if ($dailySalesHistory->isEmpty())
            <p class="alert alert-info">No data available for daily sales history.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Online Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailySalesHistory as $dailySale)
                        <tr>
                            <td>{{ $dailySale->created_at->format('F j, Y') }}</td>

                            <td>Php {{ number_format($dailySale->online_sales, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

       <div class="text-center">
    <nav aria-label="Page navigation example" class="d-inline-block">
        {{ $dailySalesHistory->links('pagination::bootstrap-4') }}
    </nav>
</div>


        @endif
    </div>
@endsection
