<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedCafesBrewMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cafes_brew_methods', function( $table ){
            $table->integer('cafe_id')->unsigned();
            $table->foreign('cafe_id')->references('id')->on('cafes');
            $table->integer('brew_method_id')->unsigned();
            $table->foreign('brew_method_id')->references('id')->on('brew_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cafes_brew_methods');
    }
}
