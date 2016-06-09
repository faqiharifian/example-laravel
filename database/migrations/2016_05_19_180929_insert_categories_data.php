<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Category;

class InsertCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            Category::create(['name' => 'Tables']);
            Category::create(['name' => 'Chairs']);
            Category::create(['name' => 'Armchairs']);
            Category::create(['name' => 'Sofas']);
            Category::create(['name' => 'Longers']);
            Category::create(['name' => 'Sidetables']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $categories = Category::all();
            foreach($categories as $category){
                $category->delete();
            }
        });
    }
}
