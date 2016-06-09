<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ProductTag;

class InsertProductTagData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        for($i = 1; $i<=12; $i++){
            $countTag = rand(1, 6);
            $tags = $this->generateTag(6 - $countTag);
            for($j = 0; $j < $countTag; $j++){
                ProductTag::create([
                    'name' => $tags[$j],
                    'product_id' => $i
                ]);
            }

        }
    }

    private function generateTag($countTag){
        $tags = ['wood', 'plywood', 'blockboard', 'particle board', 'mdf', 'teakblock'];
        for($i = $countTag; $i > 0 ; $i--){
            array_pull($tags, rand(0, $i));
        }
        $result = [];
        $i = 0;
        foreach($tags as $tag){
            $result[$i++] = $tag;
        }
        return $result;
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
