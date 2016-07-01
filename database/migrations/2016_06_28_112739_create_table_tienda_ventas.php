<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTiendaVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda_ventas', function ($table) {
            $table->increments('id');
            $table->date('fecha', 30); 
            $table->boolean('anulado'); 
            $table->decimal('total', 4, 2);
            $table->decimal('base10', 4, 2);
            $table->decimal('iva10', 4, 2);
            $table->decimal('base21', 4, 2);
            $table->decimal('iva21', 4, 2);
            $table->string('pago', 10); // tarjeta, efectivo
            $table->integer('linea0');
            $table->integer('linea1');
            $table->integer('linea2');
            $table->integer('linea3');
            $table->integer('linea4');
            $table->integer('linea5');
            $table->integer('linea6');
            $table->integer('linea7');
            $table->integer('linea8');
            $table->integer('linea9');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tienda_ventas');
    }
}
