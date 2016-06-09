<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use League\CommonMark\CommonMarkConverter;

class InsertDetailHtmlDataProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $converter = new CommonMarkConverter();
        $products = \App\Models\Product::all();
        foreach($products as $product){
            $product->detail_html = e($converter->convertToHtml($product->detail));
            $product->save();
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
