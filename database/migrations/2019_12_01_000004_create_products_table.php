<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('image');
            $table->string('colour');
            $table->string('currency');
            $table->float('price', 8 , 2);
            $table->string('model')->nullable();
            $table->string('quality')->nullable();
            $table->boolean('status');
            $table->tinyInteger('stock');
            $table->text('description_detail')->nullable();
            $table->text('description_general')->nullable();
            $table->string('description_title')->nullable();
            $table->string('description_model')->nullable();
            $table->string('description_quality')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('products');
    }
}
