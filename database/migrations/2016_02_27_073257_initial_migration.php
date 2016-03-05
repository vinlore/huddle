<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class InitialMigration extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->boolean('is_owner');
            $table->string('email');
            $table->string('phone');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('city');
            $table->string('country');
            $table->date('birthday');
            $table->string('gender');
            $table->timestamps();

            $table->unique(['user_id', 'is_owner']);

            $table->foreign('user_id', 'profiles_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('accommodations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('accommodation_id')->index('accommodation_id');
            $table->integer('room_no');
            $table->integer('guest_count')->default(0);
            $table->integer('capacity');
            $table->timestamps();

            $table->foreign('accommodation_id', 'rooms_ibfk_1')->references('id')->on('accommodations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('inventory_id')->index('inventory_id');
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->unique(['id','inventory_id'], 'id');

            $table->foreign('inventory_id', 'items_ibfk_1')->references('id')->on('inventories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('conferences', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->integer('attendee_count')->default(0);
            $table->integer('capacity');
            $table->integer('inventory_id')->index('inventory_id');
            $table->string('transportation')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->timestamps();

            $table->foreign('inventory_id', 'conferences_ibfk_1')->references('id')->on('inventories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('conference_id')->index('conference_id');
            $table->string('name');
            $table->string('facilitator');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('age_limit')->nullable();
            $table->string('gender_limit')->nullable();
            $table->integer('attendee_count')->default(0);
            $table->integer('capacity');
            $table->string('transportation')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->timestamps();

            $table->foreign('conference_id', 'events_ibfk_1')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');

        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('passenger_count')->default(0);
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('conference_vehicles', function (Blueprint $table) {
            $table->integer('vehicle_id');
            $table->integer('conference_id')->index('conference_id');
            $table->timestamps();

            $table->foreign('conference_id', 'conference_vehicles_ibfk_1')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('event_vehicles', function (Blueprint $table) {
            $table->integer('vehicle_id');
            $table->integer('event_id')->index('event_id');
            $table->timestamps();

            $table->foreign('event_id', 'event_vehicles_ibfk_1')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('conference_accommodations', function (Blueprint $table) {
            $table->integer('conference_id');
            $table->integer('accommodation_id')->index('accommodation_id');
            $table->primary(['conference_id','accommodation_id']);
            $table->timestamps();

            $table->foreign('conference_id', 'conference_accommodations_ibfk_1')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('accommodation_id', 'conference_accommodations_ibfk_2')->references('id')->on('accommodations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('user_manages_conferences', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('conference_id')->index('conference_id');
            $table->primary(['user_id','conference_id']);
            $table->timestamps();

            $table->foreign('user_id', 'user_manages_conferences_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('conference_id', 'user_manages_conferences_ibfk_2')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('user_manages_events', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('event_id')->index('event_id');
            $table->primary(['user_id','event_id']);
            $table->timestamps();

            $table->foreign('user_id', 'user_manages_events_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('event_id', 'user_manages_events_ibfk_2')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('user_manages_inventories', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('inventory_id')->index('inventory_id');
            $table->primary(['user_id','inventory_id']);
            $table->timestamps();

            $table->foreign('user_id', 'user_manages_inventories_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('inventory_id', 'user_manages_inventories_ibfk_2')->references('id')->on('inventories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('profile_attends_conferences', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('conference_id')->index('conference_id');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('city');
            $table->string('country');
            $table->date('birthday');
            $table->string('gender');
            $table->boolean('arrv_ride_req');
            $table->date('arrv_date')->nullable();
            $table->string('arrv_airport')->nullable();
            $table->string('arrv_flight_no')->nullable();
            $table->boolean('dept_ride_req');
            $table->date('dept_date')->nullable();
            $table->string('dept_airport')->nullable();
            $table->string('dept_flight_no')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('medical_conditions')->nullable();
            $table->primary(['profile_id','conference_id']);
            $table->timestamps();

            $table->foreign('profile_id', 'profile_attends_conferences_ibfk_1')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('conference_id', 'profile_attends_conferences_ibfk_2')->references('id')->on('conferences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('profile_attends_events', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('event_id')->index('event_id');
            $table->boolean('ride_req');
            $table->primary(['profile_id','event_id']);
            $table->timestamps();

            $table->foreign('profile_id', 'profile_attends_events_ibfk_1')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('event_id', 'profile_attends_events_ibfk_2')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('profile_stays_in_rooms', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('room_id')->index('room_id');
            $table->primary(['profile_id','room_id']);
            $table->timestamps();

            $table->foreign('profile_id', 'profile_stays_in_rooms_ibfk_1')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('room_id', 'profile_stays_in_rooms_ibfk_2')->references('id')->on('rooms')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });

        Schema::create('profile_rides_vehicles', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('vehicle_id')->index('vehicle_id');
            $table->primary(['profile_id','vehicle_id']);
            $table->timestamps();

            $table->foreign('profile_id', 'profile_rides_vehicles_ibfk_1')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('vehicle_id', 'profile_rides_vehicles_ibfk_2')->references('id')->on('vehicles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_rides_vehicles');
        Schema::drop('profile_stays_in_rooms');
        Schema::drop('profile_attends_events');
        Schema::drop('profile_attends_conferences');
        Schema::drop('user_manages_inventories');
        Schema::drop('user_manages_events');
        Schema::drop('user_manages_conferences');
        Schema::drop('conference_accommodations');
        Schema::drop('event_vehicles');
        Schema::drop('conference_vehicles');

        Schema::drop('vehicles');
        Schema::drop('events');
        Schema::drop('conferences');
        Schema::drop('items');
        Schema::drop('inventories');
        Schema::drop('rooms');
        Schema::drop('accommodations');
        Schema::drop('profiles');
    }
}
