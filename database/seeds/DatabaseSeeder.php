<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('profiles')->truncate();
        DB::table('role_users')->truncate();
        DB::table('conferences')->truncate();
        DB::table('events')->truncate();
        DB::table('accommodations')->truncate();
        DB::table('rooms')->truncate();
        DB::table('items')->truncate();
        DB::table('vehicles')->truncate();
        DB::table('conference_accommodations')->truncate();
        DB::table('conference_vehicles')->truncate();
        DB::table('event_vehicles')->truncate();
        DB::table('user_manages_conferences')->truncate();
        DB::table('user_manages_events')->truncate();
        DB::table('profile_attends_conferences')->truncate();
        DB::table('profile_attends_events')->truncate();
        DB::table('profile_stays_in_rooms')->truncate();
        DB::table('profile_rides_vehicles')->truncate();
        DB::table('activities')->truncate();

        $this->call(ActivitySeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(ConferencesAndEventsSeeder::class);
        $this->call(UsersAndProfilesSeeder::class);
        $this->call(AccommodationsAndRoomsSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(VehiclesSeeder::class);
        $this->call(ManagersSeeder::class);
        $this->call(AttendeesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}
