<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTiendaArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda_articulos', function ($table) {
            $table->increments('id');
            $table->string('seccion', 30); // Promoted, Paella Pans, Food, Kitchenware, Other
            $table->string('nombre',30); // En inglés
            $table->decimal('pvp', 4, 2);  // 
            $table->integer('iva'); // 10 o 21%
            $table->integer('display_order'); 
            $table->boolean('visible');

        });
        
        // insert initial articulos
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'Basurilla',
                'pvp' => 100000,
                'iva' => 10000,
                'visible' => false));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'OLD Saffron (1gr jar)',
                'pvp' => 7.50,
                'iva' => 10,
                'visible' => false));
 
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Cooking Classes',
                'nombre' => 'Cooking Class (Adult)',
                'pvp' => 70,
                'iva' => 21,
                'display_order' => 200,
                'visible' => true));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Cooking Classes',
                'nombre' => 'Cooking Class (Child)',
                'pvp' => 35,
                'iva' => 21,
                'display_order' => 210,
                'visible' => true));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'Saffron (1gr jar)',
                'pvp' => 10,
                'iva' => 10,
                'display_order' => 100,
                'visible' => true));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'OLD Paprika',
                'pvp' => 3,
                'iva' => 10,
                'visible' => false));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'Paprika',
                'pvp' => 5,
                'iva' => 10,
                'display_order' => 110,
                'visible' => true));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Promoted',
                'nombre' => 'Apron',
                'pvp' => 20,
                'iva' => 21,
                'display_order' => 120,
                'visible' => true));            

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Pans',
                'nombre' => '30cm / 12" Paella Pan',
                'pvp' => 15,
                'iva' => 21,
                'display_order' => 300,
                'visible' => true));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Pans',
                'nombre' => 'OLD 30cm / 12" Paella Pan',
                'pvp' => 10,
                'iva' => 21,
                'visible' => false));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Pans',
                'nombre' => '34cm / 13.5" Paella Pan',
                'pvp' => 20,
                'iva' => 21,
                'display_order' => 310,
                'visible' => true));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Pans',
                'nombre' => 'OLD 34cm / 13.5" Paella Pan',
                'pvp' => 15,
                'iva' => 21,
                'visible' => false));

        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Pans',
                'nombre' => '38cm / 15" Paella Pan',
                'pvp' => 25,
                'iva' => 21,
                'display_order' => 320,
                'visible' => true));  
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => 'OLD 12cm Terracotta Pot',
                'pvp' => 2.50,
                'iva' => 21,
                'visible' => true));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => '12cm Terracotta Pot',
                'pvp' => 5,
                'iva' => 21,
                 'display_order' => 400,
               'visible' => true));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => 'OLD 14cm Terracotta Pot',
                'pvp' => 3,
                'iva' => 21,
                'visible' => false));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => '14cm Terracotta Pot',
                'pvp' => 6,
                'iva' => 21,
                 'display_order' => 410,
                'visible' => true));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => 'OLD Mini Pan',
                'pvp' => 3,
                'iva' => 21,
                'visible' => false));
        DB::table('tienda_articulos')->insert(
            array(
                'seccion' => 'Kitchenware',
                'nombre' => 'Mini Pan',
                'pvp' => 6,
                'iva' => 21,
                'display_order' => 420,
                'visible' => true));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tienda_articulos');
    }
}