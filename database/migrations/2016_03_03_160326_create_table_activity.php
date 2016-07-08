<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function ($table) {
            $table->increments('id');
            $table->string('atype', 100); // paella cooking class, group event, festivo, bloqueado
            $table->string('shortcode',10); // PAELLA, TAPAS, GROUP, HOLIDAY, BLOCKED,
            $table->time('start_time');  // zero if not regular class (holidays, group, blocked,...)
            $table->time('end_time'); // zero if not regular class
            $table->string('shift', 4); // am, pm, any
            $table->boolean('visible'); // It appears on web pages
            $table->float('price_adult'); // excluding VAT
            $table->integer('price_child');
            $table->integer('max_size');  // max number students
            $table->date('created_at');
            $table->date('updated_at');
        });
        
        // insert initial activities
        DB::table('activities')->insert(
            array(
                'atype' => 'Paella Cooking Class',
                'shortcode' => '01-PAELLA',
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
                'shift' => 'am',
                'visible' => true,
                'price_adult' => 70/1.21,
                'price_child' => 35/1.21,
                'max_size' => 12));
            
        DB::table('activities')->insert(
            array(
                'atype' => 'Tapas Cooking Class',
                'shortcode' => '02-TAPAS',
                'start_time' => '17:30:00',
                'end_time' => '21:30:00',
                'shift' => 'pm',
                'visible' => true,
                'price_adult' => 70/1.21,
                'price_child' => 35/1.21,
                'max_size' => 12));
        
        DB::table('activities')->insert(
            array(
                'atype' => 'Group Event',
                'shortcode' => '03-GROUP',
                'shift' => 'any',
                'visible' => false ));

        DB::table('activities')->insert(
            array(
                'atype' => 'Holiday',
                'shortcode' => '04-HOLIDAY',
                'shift' => 'any',
                'visible' => false ));
                

        DB::table('activities')->insert(
            array(
                'atype' => 'Blocked',
                'shortcode' => '05-LOCKED',
                'shift' => 'any',
                'visible' => false ));
                        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::drop('activities');
    }
}
