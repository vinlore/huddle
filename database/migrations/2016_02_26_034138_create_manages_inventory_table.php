<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagesInventoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manages_inventory', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('inventory_id')->index('inventory_id');
			$table->primary(['user_id','inventory_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manages_inventory');
	}

}
