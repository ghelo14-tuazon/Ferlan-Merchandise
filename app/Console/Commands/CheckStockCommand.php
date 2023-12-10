<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CheckStockCommand extends Command
{
    protected $signature = 'check:stock';
    protected $description = 'Check stock levels and send alerts';

    public function handle()
    {
        // Set the threshold for low stock
        $lowStockThreshold = 60; // You can adjust this value based on your needs
    
        // Retrieve products with low stock
        $lowStockProducts = DB::table('products')->where('stock', '<', $lowStockThreshold)->get();
    
        // Send alert or perform any other necessary action
        if ($lowStockProducts->isNotEmpty()) {
            // Example: Log the low stock alert and product details
            $message = 'Low stock alert! Some products have stock levels below ' . $lowStockThreshold.".";
            $this->comment($message);
    
            // Log or display details for each low stock product
            foreach ($lowStockProducts as $product) {
                $productDetails = " Name: $product->title, Stock: $product->stock";
                $this->comment($productDetails);
    
                // You can also log the alert or trigger any other notifications
                // For example: Log::info('Low stock alert: ' . json_encode($lowStockProducts));
            }
        } else {
           
        }
    }
}