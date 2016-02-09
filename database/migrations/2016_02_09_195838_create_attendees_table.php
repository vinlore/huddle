<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age')->unsigned();
            $table->string('city');
            $table->string('country');

            $table->boolean('arrival_ride_req');
            $table->dateTime('arrival_date_time');
            $table->string('arrival_airport');
            $table->string('arrival_flight_num');
            $table->boolean('depart_ride_req');
            $table->dateTime('depart_date_time');
            $table->string('depart_airport');
            $table->string('depart_flight_num');

            //varchar(15) international standards support numbers up to 15 digits
            $table->string('home_phone', 15); 
            $table->string('india_phone', 15); 
            $table->string('email');
            $table->string('emergency_contact');
            $table->string('emergency_contact_phone', 15);
            $table->string('medical_conditions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendees');
    }
}
