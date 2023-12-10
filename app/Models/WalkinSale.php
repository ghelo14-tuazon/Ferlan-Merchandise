<?php

// app/WalkinSale.php

// app/Models/WalkinSale.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalkinSale extends Model
{
    protected $fillable = ['product_id', 'quantity', 'total_price','size'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}

