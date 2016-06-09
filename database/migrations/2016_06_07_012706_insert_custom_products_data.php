<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCustomProductsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i = 0; $i < 50; $i++){
            $new = rand(1, 10) < 5 ? true : false;
            \App\Models\CustomProduct::create([
                'specification' => 'Specification '.($i+1).'. Donec mi odio faucibus at',
                'detail' => 'Detail '.($i+1).'. Pellentesque ut neque. Maecenas malesuada. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Quisque id odio.',
                'name' => 'Name '.($i+1),
                'email' => 'email'.($i+1).'@gmail.com',
                'phone' => '082242345075',
                'new' => $new,
            ]);

            $image = rand(1, 10) < 7 ? ($i+1).'.jpg' : '';
            \App\Models\CustomProductImage::create([
                'image' => $image,
                'custom_product_id' => $i+1,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
