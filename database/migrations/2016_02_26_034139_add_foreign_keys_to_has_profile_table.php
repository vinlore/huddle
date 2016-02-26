<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHasProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('has_profile', function(Blueprint $table)
		{
			$table->foreign('user_id', 'has_profile_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('profile_id', 'has_profile_ibfk_2')->references('profile_id')->on('profile')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('has_profile', function(Blueprint $table)
		{
			$table->dropForeign('has_profile_ibfk_1');
			$table->dropForeign('has_profile_ibfk_2');
		});
	}

}
