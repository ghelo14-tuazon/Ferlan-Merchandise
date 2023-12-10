<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonthAndYearToDailySalesTable extends Migration
{
    public function up()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
        });
    }

    public function down()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
    }
}

