<?php

// database/migrations/2023_01_01_create_stock_history_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('stock_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_history');
    }
}

