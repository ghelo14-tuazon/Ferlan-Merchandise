<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySale extends Model

    {
        use HasFactory;
    
        protected $fillable = ['date', 'online_sales', 'walkthrough_sales', 'total_sales'];
        public $timestamps = true;
    }

