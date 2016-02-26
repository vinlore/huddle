<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendsConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attends_conference', function(Blueprint $table)
		{
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
			$table->integer('arrv_flight_no')->nullable();
			$table->boolean('dept_ride_req');
			$table->date('dept_date')->nullable();
			$table->string('dept_airport')->nullable();
			$table->integer('dept_flight_no')->nullable();
			$table->string('emergency_contact_name')->nullable();
			$table->string('emergency_contact_phone')->nullable();
			$table->string('medical_conditions')->nullable();
			$table->primary(['profile_id','conference_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attends_conference');
	}

}
