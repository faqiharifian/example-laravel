<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class InsertUserData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            User::create([
                'email' => 'airlangga@durenworks.com',
                'password' => bcrypt('durenworks')
            ]);
            User::create([
                'email' => 'faqih@arifian.com',
                'password' => bcrypt('fi180818')
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $users = User::all();
            foreach($users as $user){
                $user->delete();
            }
        });
    }
}
