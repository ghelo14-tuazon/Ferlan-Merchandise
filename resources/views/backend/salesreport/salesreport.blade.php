<!-- resources/views/backend/salesreport.blade.php -->

@extends('backend.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-danger text-white text-center">Sales Reports</div>

                    <div class="card-body">
                        <h4 class="text-center mb-4">Daily Sales Report</h4>
                        @if ($dailyReport)
                            <p class="mb-1"><strong>Date:</strong> {{ $dailyReport['date'] }}</p>
                            <p class="mb-1"><strong>Total Sales:</strong> Php {{ $dailyReport['total_sales'] }}</p>
                        @else
                            <p>No data available for daily sales report.</p>
                        @endif
<div class="text-center mb-4">
    <a href="{{ route('dailySalesHistory') }}" class="btn btn-primary">View Daily Sales History</a>
</div>
                        <hr>

             <h4 class="text-center mb-4">Monthly Sales Report</h4>

@if ($monthlyReport)
  <p class="mb-1"><strong>Month:</strong> {{ $monthlyReport->created_at->format('F') }}</p>

    <p class="mb-1"><strong>Total Sales:</strong> Php {{ number_format($monthlyReport->total_sales, 2) }}</p>
@else
    <p>No data available for the current month's sales report.</p>
@endif




                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white text-center">Yearly Sales Report  ({{ now()->year }})</div>
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Month</th>
                            <th class="text-center">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalYearlySales = 0;
                        @endphp

                       @foreach($yearlyReport['monthly_sales'] as $month => $totalSales)
    <tr>
        <td class="text-center">{{ $month }}</td>
        <td class="text-center">Php {{ number_format($totalSales, 2) }}</td>
    </tr>
                            @php
                                $totalYearlySales += $totalSales;
                            @endphp
                        @endforeach

                        <tr class="bg-info text-white">
                            <td class="text-center"><strong>Total</strong></td>
                            <td class="text-center"><strong>Php {{ number_format($totalYearlySales, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
