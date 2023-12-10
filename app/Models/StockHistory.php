<?php
// app/Models/StockHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $table = 'stock_history';
    protected $fillable = ['product_id', 'quantity','size', 'created_at', 'updated_at'];

    // Relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
   
}
