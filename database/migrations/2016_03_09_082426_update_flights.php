<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFlights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_attends_conferences', function (Blueprint $table) {
            $table->dropColumn('arrv_date');
            $table->dropColumn('arrv_airport');
            $table->dropColumn('arrv_flight_no');
            $table->dropColumn('dept_date');
            $table->dropColumn('dept_airport');
            $table->dropColumn('dept_flight_no');
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('conference_id')->index('conference_id');
            $table->enum('type', ['arrival', 'departure',]);
            $table->date('date');
            $table->time('time');
            $table->string('airport');
            $table->string('number');
            $table->timestamps();

            $table->foreign('conference_id', 'flights_ibfk_1')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('profile_takes_flights', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('flight_id')->index('flight_id');
            $table->primary(['profile_id', 'flight_id',]);
            $table->timestamps();

            $table->foreign('profile_id', 'profile_takes_flights_ibfk_1')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('flight_id', 'profile_takes_flights_ibfk_2')->references('id')->on('flights')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_takes_flights');
        Schema::drop('flights');
    }
}
