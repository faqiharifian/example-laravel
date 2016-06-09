<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('custom_product_id')->unsigned();

            $table->foreign('custom_product_id')->references('id')->on('custom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('custom_product_images');
    }
}
