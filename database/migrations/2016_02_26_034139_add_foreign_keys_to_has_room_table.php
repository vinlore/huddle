<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHasRoomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('has_room', function(Blueprint $table)
		{
			$table->foreign('accommodation_id', 'has_room_ibfk_1')->references('accommodation_id')->on('accommodation')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('room_id', 'has_room_ibfk_2')->references('room_id')->on('room')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('has_room', function(Blueprint $table)
		{
			$table->dropForeign('has_room_ibfk_1');
			$table->dropForeign('has_room_ibfk_2');
		});
	}

}
