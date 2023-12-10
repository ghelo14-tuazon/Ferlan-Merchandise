<?php

// database/migrations/yyyy_mm_dd_add_date_to_daily_sales_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToDailySalesTable extends Migration
{
    public function up()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->date('date');
        });
    }

    public function down()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}
