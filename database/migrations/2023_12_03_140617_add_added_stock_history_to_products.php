<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// In the generated migration file
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->integer('added_stock_history')->default(0);
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('added_stock_history');
    });
}

};
