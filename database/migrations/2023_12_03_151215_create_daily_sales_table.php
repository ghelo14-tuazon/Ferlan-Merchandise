<?php
// database/migrations/yyyy_mm_dd_create_daily_sales_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySalesTable extends Migration
{
    public function up()
    {
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('online_sales', 10, 2)->default(0);
            $table->decimal('walkthrough_sales', 10, 2)->default(0);
            $table->decimal('total_sales', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    

   
}
