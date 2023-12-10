{{-- resources/views/staff/dailysale/dailysales.blade.php --}}

@extends('staff.layout.master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4 text-center">Daily Sales Report</h1>

    <table class="table table-bordered mt-4">
        <thead class="thead-blue">
            <tr>
                <th>Date</th>
                <th>Online Sales</th>
                <th>Walkthrough Sales</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dailySales['all_daily_sales'] as $daily)
                <tr>
                <td>{{ \Carbon\Carbon::parse($daily['date'])->format('F j, Y') }}</td>

                    <td>Php {{ number_format($daily['online_sales'], 2) }}</td>
                    <td>Php {{ number_format($daily['walkthrough_sales'], 2) }}</td>
                    <td>Php {{ number_format($daily['total_sales'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No daily sales records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $dailySales['all_daily_sales']->links("pagination::bootstrap-4") }}
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@endsection
