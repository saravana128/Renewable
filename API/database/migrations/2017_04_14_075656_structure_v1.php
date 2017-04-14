<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StructureV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities',function(Blueprint $table){
            $table->increments('id');
            $table->string('city_name');
            $table->string('country');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('w_users',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::create('winds',function(Blueprint $table){
            $table->increments('id');
            $table->integer('lat_from');
            $table->integer('lon_from');
            $table->integer('lat_to');
            $table->integer('lon_to');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('wind_speed');
            $table->integer('direction');
            $table->timestamps();
            $table->softDeletes();


        });
        Schema::create('s_users',function(Blueprint $table){
            $table->increments('id');
            $table->integer('s_user_id');
            $table->string('s_user_name');
            $table->string('s_password');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('solars',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('s_user_id')->on('s_user')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('fans');
            $table->integer('lights');
            $table->timestamps();
            $table->softDeletes();
        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city');
        Schema::drop('user');
        Schema::drop('wind');
        Schema::drop('s_user');
        Schema::drop('solar');

    }
}
