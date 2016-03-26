<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityLogMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //user doing the action
            //action concerning
            $table->string('activity_type'); // status: request, approved/declined, created, updated, deleted
            $table->integer('source_id');   //conference_id, event_id, user_id
            $table->string('source_type'); //"conference", "event", "attendee"
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('user_id', 'activity_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
