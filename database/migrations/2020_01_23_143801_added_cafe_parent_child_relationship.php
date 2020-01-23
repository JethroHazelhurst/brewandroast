<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedCafeParentChildRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cafes', function( Blueprint $table ){
            $table->integer('parent')->unsigned()->nullable()->after('id');
            $table->foreign('parent')->references('id')->on('cafes');
            $table->string('location_name')->after('name');
            $table->integer('roaster')->after('longitude');
            $table->text('website')->after('roaster');
            $table->text('description')->after('website');
            $table->bigInteger('added_by')->after('description')->unsigned()->nullable();
            $table->foreign('added_by')->references('id')->on('users');
        });
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