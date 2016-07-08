<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function ($table) {
            $table->increments('id');
            $table->integer('calendar_event_id');
            $table->string('status',10); // CREATED, CANCELLED, PAID
            $table->string('name');  // client name
            $table->string('email');  // client email
            $table->string('phone');  // client phone
            $table->integer('adults'); 
            $table->integer('children'); 
            $table->float('price'); // excluding VAT
            $table->string('pay_method',10); // online, viator, transfer, cash
            $table->string('foodrestrictions');
            $table->string('comments');
            $table->string('created_by');  // online, viator, manual
            $table->string('source');  // viator, hotel, street, phone, travel agent
            $table->string('partner');  // viator, westin palace, whattodo, vistingo, century incoming,...
            $table->date('created_at');
            $table->date('updated_at');
        });
        
        DB::table('bookings')->insert(
            array( // grupo, todo el día, confirmado
                'name' => 'John Smith',
                'calendar_event_id'=> 6,
                'status' =>'CONFIRMED',
                'adults' => 18,
                'price' => 850.00));
        
        DB::table('bookings')->insert(
            array(  
                'name' => 'Otto Kinsley',
                'calendar_event_id'=> 2,
                'status' =>'PAID',
                'adults' => 5,
                'children' => 1,
                'price' => 100.00));
        
        DB::table('bookings')->insert(
            array( 
                'name' => 'Paul Newman',
                'calendar_event_id'=> 2,
                'status' =>'PAID',
                'adults' => 1,
                'children' => 2,
                'price' => 120.00));
        
        DB::table('bookings')->insert(
            array(
                'name' => 'Marlon Brando',
                'calendar_event_id'=> 3,
                'status' =>'PAID',
                'adults' => 2,
                'children' => 1,
                'price' => 100.00));
        
        DB::table('bookings')->insert(
            array(
                'name' => 'Fred Astaire',
                'calendar_event_id'=> 3,
                'status' =>'PAID',
                'adults' => 1,
                'children' => 0,
                'price' => 120.00));
        DB::table('bookings')->insert(
            array(
                'name' => 'Frank Sinatra',
                'calendar_event_id'=> 4,
                'status' =>'PAID',
                'adults' => 3,
                'children' => 2,
                'price' => 120.00));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookings');
    }
}
