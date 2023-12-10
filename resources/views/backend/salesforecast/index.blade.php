<!-- resources/views/backend/salesforecast/index.blade.php -->

@extends('backend.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto"> <!-- Center the card and its content -->
                <div class="card">
                    <div class="card-header bg-danger text-black text-center"> <!-- Set background color to danger and text color to black -->
                       <h5 class="mb-0" style="color: WHITE;">Sales Forecasting</h5>

                    </div>

                    <div class="card-body">
                        <h6 class="font-weight-bold mb-3 text-center">Monthly Sales Data (Current Year)</h6>
                        <table class="table table-bordered text-center"> <!-- Center the table content -->
                            <thead class="thead-success"> <!-- Set background color to success for the table header -->
                                <tr>
                                    <th>Month</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlySales as $data)
                                    <tr>
                                        <td>{{ $data['month'] }}</td>
                                        <td>Php {{ number_format($data['total'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h6 class="font-weight-bold mt-4 mb-3 text-center">Monthly Sales Forecast (Next Year)</h6>
                        <table class="table table-bordered text-center"> <!-- Center the table content -->
                            <thead class="thead-success"> <!-- Set background color to success for the table header -->
                                <tr>
                                    <th>Month</th>
                                    <th>Total Sales Forecast</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nextYearForecast as $data)
                                    <tr>
                                        <td>{{ $data['month'] }}</td>
                                        <td>Php {{ number_format($data['total'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
