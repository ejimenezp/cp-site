<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsercredential extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credentials', function ($table) {
            $table->increments('id');
            $table->string('userid', 10);
            $table->string('username', 10);
            $table->string('action', 20);  
        });

        DB::table('user_credentials')->insert( array(
                'userid' => 'paulina',
                'username' => 'paulina',
                'action' => 'MENU_ACTIVITIES'));

    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_credentials');

    }
}
