<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCalendarevent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function ($table) {
            $table->increments('id');
            $table->date('start_date');
            $table->time('start_time');  // zero if not class (holidays, blocked,...)
            $table->string('start_shift', 2);  // am, pm
            $table->date('end_date');
            $table->time('end_time');  // zero if not class (holidays, blocked,...)
            $table->string('end_shift', 2); // am, pm
            $table->integer('activity_id');  // from activities table
            $table->string('status', 15); // CONFIRMED, NOT_CONFIRMED, CANCELLED
            $table->string('comments', 30);
            $table->integer('registered'); // current registered (confirmed,paid,adult,child)
            $table->date('created_at');
            $table->date('updated_at');
        });
    

    DB::table('calendar_events')->insert(
        array( // holidays
            'start_date' => '2016-01-06',
            'start_shift' => 'am',
            'end_date' => '2016-01-09',
            'end_shift' =>'pm',
            'status' => 'CONFIRMED',
            'comments' => 'vacaciones enero',
            'activity_id' => 4));
        
        DB::table('calendar_events')->insert(
        array( // paella
            'start_date' => '2016-01-11',
            'start_shift' => 'am',
            'end_date' => '2016-01-11',
            'end_shift' => 'am',
            'status' => 'CONFIRMED',
            'registered' => 9,
            'activity_id' => 1));

    DB::table('calendar_events')->insert(
        array( // tapas
            'start_date' => '2016-01-11',
            'start_shift' => 'pm',
            'end_date' => '2016-01-11',
            'end_shift' => 'pm',
            'status' => 'CONFIRMED',
            'registered' => 9,
            'activity_id' => 2));

    DB::table('calendar_events')->insert(
        array( // tapas
            'start_date' => '2016-01-13',
            'start_shift' => 'pm',
            'end_date' => '2016-01-13',
            'end_shift' => 'pm',
            'status' => 'CONFIRMED',
            'registered' => 4,
            'activity_id' => 2));
    
    DB::table('calendar_events')->insert(
        array( // grupo, todo el día, sin confirmar
            'start_date' => '2016-01-15',
            'start_shift' => 'am',
            'end_date' => '2016-01-15',
            'end_shift' =>'pm',
            'status' => 'NOT_CONFIRMED',
            'comments' => 'grupo ruso',
            'activity_id' => 3));
    
    DB::table('calendar_events')->insert(
        array( // grupo, todo el día, confirmado
            'start_date' => '2016-01-16',
            'start_shift' => 'am',
            'end_date' => '2016-01-16',
            'end_shift' =>'pm',
            'status' => 'CONFIRMED',
            'comments' => 'smithkline empresa',
            'activity_id' => 3));
    
    DB::table('calendar_events')->insert(
        array( // holidays
            'start_date' => '2016-01-18',
            'start_shift' => 'am',
            'end_date' => '2016-01-21',
            'end_shift' =>'pm',
            'status' => 'CONFIRMED',
            'comments' => 'dia del cocinero',
            'activity_id' => 3));

}
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendar_events');

    }
}
