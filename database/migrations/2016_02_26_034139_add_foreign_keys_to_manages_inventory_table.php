<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToManagesInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('manages_inventory', function(Blueprint $table)
		{
			$table->foreign('user_id', 'manages_inventory_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('inventory_id', 'manages_inventory_ibfk_2')->references('inventory_id')->on('inventory')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('manages_inventory', function(Blueprint $table)
		{
			$table->dropForeign('manages_inventory_ibfk_1');
			$table->dropForeign('manages_inventory_ibfk_2');
		});
	}

}
