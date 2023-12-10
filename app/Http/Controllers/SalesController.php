<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use Notification;
use App\User;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Carbon\Carbon;
use App\Models\DailySale;
use App\Models\MonthlySale;
use App\Models\YearlySale;
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $dailyReport = $this->dailySalesReport();
        $monthlyReport = $this->monthlySalesReport();
        $yearlyReport = $this->yearlySalesReport();
        return view('backend.salesreport.salesreport', compact('dailyReport', 'monthlyReport', 'yearlyReport'));
    }

   
private function dailySalesReport()
{
    $today = now()->toDateString();
    $dailySale = DailySale::whereDate('date', $today)->first();

    if ($dailySale) {
        $totalSales = $dailySale->online_sales;
        // If you want to format the total sales, you can use the number_format function
        $formattedTotalSales = number_format($totalSales, 2);

        return ['date' => $today, 'total_sales' => $formattedTotalSales];
    } else {
        return ['date' => $today, 'total_sales' => 0];
    }
}
   


    private function monthlySalesReport()
    {
        $currentYear = now()->year;
    
        // Loop through all months
        for ($currentMonth = 1; $currentMonth <= 12; $currentMonth++) {
            $orders = Order::with(['cart_info'])
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->where('status', 'delivered')
                ->get();
    
            $totalSales = $orders->flatMap(function ($order) {
                return $order->cart_info->pluck('amount');
            })->sum();
    
            // Update or create a record in the monthly_sales table for each month
            $monthlySale = MonthlySale::updateOrCreate(
                ['month' => $currentMonth, 'year' => $currentYear],
                ['total_sales' => $totalSales]
            );
        }
    
        // Return the last created or updated MonthlySale instance
        return $monthlySale;
    }
    



    private function yearlySalesReport()
    {
        $currentYear = Carbon::now()->year;
        $orders = Order::with(['cart_info'])
            ->whereYear('created_at', $currentYear)
            ->where('status', 'delivered')
            ->get();
    
        $totalSales = [];
        foreach ($orders as $order) {
            $month = Carbon::parse($order->created_at)->month;
            $totalSales[$month] = ($totalSales[$month] ?? 0) + $order->cart_info->sum('amount');
        }
    
        $totalYearlySales = array_sum($totalSales);
    
        // Store the total in the yearly_sales table
        YearlySale::updateOrCreate(
            ['year' => $currentYear],
            ['total_sales' => $totalYearlySales]
            
        );
    
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = ($totalSales[$i] ?? 0);
        }
    
        return ['total_sales' => $totalYearlySales, 'monthly_sales' => $data, 'yearly_sales' => $data];
    }
    
    public function dailySalesHistory()
    {
        $dailySalesHistory = DailySale::orderBy('created_at', 'desc')->paginate(4); // Adjust the number per page as needed
        
        return view('backend.salesreport.daily_sales_history', compact('dailySalesHistory'));
    }
    public function yearly_sales()
    {
        $yearlySalesData = YearlySale::pluck('total_sales', 'year')->all();
    
        return response()->json(['year' => $yearlySalesData]);
    }
    

    
}
