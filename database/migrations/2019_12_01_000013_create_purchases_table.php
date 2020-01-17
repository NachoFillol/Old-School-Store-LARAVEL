<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->unsignedBigInteger('paymentmethod_id')->nullable();
            $table->unsignedBigInteger('paymentcard_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('currency');
            $table->float('shipping_price', 8, 2);
            $table->float('tax_perc', 5, 2);
            $table->float('total_price', 8, 2);
            $table->string('invoice_url')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('shipment_id')->references('id')->on('shipments');
            $table->foreign('paymentmethod_id')->references('id')->on('paymentmethods');
            $table->foreign('paymentcard_id')->references('id')->on('paymentcards');
            $table->foreign('discount_id')->references('id')->on('discounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
