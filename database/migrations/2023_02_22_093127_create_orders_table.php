<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('product_id');
            $table->string('product_qty');
            $table->integer('product_prc');
            $table->string('bill_name');
            $table->string('bill_Phone');
            $table->string('bill_email');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('address1');
            $table->string('address2');
            $table->string('pin_code');
            $table->string('payment_mode');
            $table->string('payment_id');
            $table->string('order_status');
            $table->string('tracking_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
