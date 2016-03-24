<?php

/**
 * Part of the Sentinel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Sentinel
 * @version    2.0.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCartalystSentinel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('persistences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code')->unique();
            $table->timestamps();
        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->boolean('completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name', 255)->unique();
            $table->text('permissions');
            $table->timestamps();
        });

        Schema::create('role_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->nullableTimestamps();

            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('throttle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->string('type');
            $table->string('ip')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('api_token', 96)->nullable();
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->text('permissions')->nullable();
            $table->boolean('receive_email')->default(false);
            $table->timestamp('last_login')->nullable();
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
        Schema::drop('users');
        Schema::drop('throttle');
        Schema::drop('role_users');
        Schema::drop('roles');
        Schema::drop('reminders');
        Schema::drop('persistences');
        Schema::drop('activations');
    }
}
