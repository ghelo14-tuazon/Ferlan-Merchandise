<?php
// app/Http/Controllers/WalkinSaleController.php

namespace App\Http\Controllers;

use App\Models\WalkinSale;
use Illuminate\Http\Request;

class WalkinSaleController extends Controller
{
    public function walkinSalesHistory()
    {
        $walkinSales = WalkinSale::all(); // Assuming WalkinSale model is imported
        return view('staff.walkthrough.walkin-sales-history', compact('walkinSales'));
    }
}
