<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Product;

class InsertProductData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = ['tables', 'chairs', 'armchairs', 'sofas', 'longers', 'sidetables'];
        for($i = 1; $i <= 12; $i++){
            if(fmod($i, 12) < 6){
                $type = 'indoor';
            }else{
                $type = 'outdoor';
            }

            Product::create([
                'name' => $categories[fmod($i, 6)].' '.$type.' '.$i,
                'subtitle' => 'subtitle '.$categories[fmod($i, 6)].' '.$i,
                'type' => $type,
                'width' => $i*10,
                'height' => $i*10,
                'depth' => $i*10,
                'weight' => $i*10,
                'detail' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis bibendum eros at congue. Ut imperdiet, justo convallis euismod dapibus, lectus ex laoreet felis, et consequat turpis neque quis urna. Nullam vestibulum ex eu nisi gravida condimentum. Vivamus nibh enim, egestas in velit quis, vulputate vestibulum lacus. Sed fringilla dictum dapibus.',
                'material' => 'Lorem, ipsum, dolor, sit, amet, consectetur, adipiscing, elit. ',
                'category_id' => (fmod($i, 6)+1),
//                'category_id' => 4,
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

    }
}
