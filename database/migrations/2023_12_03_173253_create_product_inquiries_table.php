<?php

// database/migrations/xxxx_xx_xx_create_product_inquiries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('product_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_inquiries');
    }
}
