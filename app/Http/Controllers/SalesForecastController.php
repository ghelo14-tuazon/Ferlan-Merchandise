<?php
// app/Http/Controllers/SalesForecastController.php
// app/Http/Controllers/SalesForecastController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesForecastController extends Controller
{
    public function index()
{
    $currentYear = Carbon::now()->year;
    $monthlySales = $this->getMonthlySales($currentYear);
    $nextYearForecast = $this->projectNextYearSales($monthlySales)
        ->filter(function ($data) {
            return $data['total'] > 0; // Filter out zero values
        });

    return view('backend.salesforecast.index', compact('monthlySales', 'nextYearForecast'));
}

    private function getMonthlySales($currentYear)
    {
        $orders = Order::with(['cart_info'])
            ->whereYear('created_at', $currentYear)
            ->where('status', 'delivered')
            ->get();
    
        $monthlySales = collect(range(1, 12))->map(function ($month) use ($orders) {
            $monthOrders = $orders->filter(function ($order) use ($month) {
                return Carbon::parse($order->created_at)->month == $month;
            });
    
            return [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'total' => $monthOrders->sum(function ($order) {
                    return $order->cart_info->sum('amount');
                }),
            ];
        });
    
        return $monthlySales;
    }

    private function projectNextYearSales($monthlySales)
    {
        $nextYearForecast = collect(range(1, 12))
            ->map(function ($month) use ($monthlySales) {
                $forecastMultiplier = $this->generateForecastMultiplier($month);
                return [
                    'month' => date('F', strtotime("+$month months", strtotime($monthlySales->last()['month']))),
                    'total' => $monthlySales->last()['total'] * $forecastMultiplier,
                ];
            });
    
        return $nextYearForecast;
    }
    
    
    
    private function generateForecastMultiplier($month)
    {
        $baseMultiplier = 1.0;
    
        // Assign specific percentage increases for each month
        $percentageIncreases = [
            10, 25, 50, 55, 60, 30, 35, 40, 45, 50, 55, 60
        ];
    
        // Ensure $month is within a valid range (1 to 12)
        $month = max(1, min(12, $month));
    
        // Use the corresponding percentage increase for the given month
        $increasePercentage = $percentageIncreases[$month - 1];
    
        $seasonalityFactor = 1.0 + $increasePercentage / 100;
    
        return $baseMultiplier * $seasonalityFactor;
    }
    

}
