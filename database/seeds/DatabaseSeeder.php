<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\Models\Accommodation;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use App\Models\Vehicle;

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

        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ConferencesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}

class RolesSeeder extends Seeder
{
    public function run()
    {
        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'system administrator',
            'name'        => 'System Administrator',
            'permissions' => [
                'conference.status'                    => true,
                'conference.store'                     => true,
                'conference.show'                      => true,
                'conference.update'                    => true,
                'conference.destroy'                   => true,
                'user.update'                          => true,
                'role.store'                           => true,
                'role.update'                          => true,
                'role.destroy'                         => true,
                'event.store'                          => true,
                'event.show'                           => true,
                'event.update'                         => true,
                'event.status'                         => true,
                'event.destroy'                        => true,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => true,
                'conferenceAttendees.destroy'          => true,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => true,
                'eventAttendees.destroy'               => true,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => true,
                'conferenceVehicles.store'             => true,
                'conferenceVehicles.show'              => true,
                'conferenceVehicles.update'            => true,
                'conferenceVehicles.destroy'           => true,
                'eventVehicles.store'                  => true,
                'eventVehicles.show'                   => true,
                'eventVehicle.update'                  => true,
                'eventVehicle.destroy'                 => true,
                'accommodations.store'                 => true,
                'accommodations.show'                  => true,
                'accommodations.update'                => true,
                'accommodations.destroy'               => true,
                'inventory.show'                       => true,
                'inventory.store'                      => true,
                'inventory.update'                     => true,
                'inventory.destroy'                    => true
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'conference manager',
            'name'        => 'Conference Manager',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => true,
                'conference.show'                      => true,
                'conference.update'                    => true,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => true,
                'event.show'                           => true,
                'event.update'                         => true,
                'event.status'                         => true,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => true,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => true,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => true,
                'conferenceVehicles.show'              => true,
                'conferenceVehicles.update'            => true,
                'conferenceVehicles.destroy'           => true,
                'eventVehicles.store'                  => true,
                'eventVehicles.show'                   => true,
                'eventVehicle.update'                  => true,
                'eventVehicle.destroy'                 => true,
                'accommodations.store'                 => true,
                'accommodations.show'                  => true,
                'accommodations.update'                => true,
                'accommodations.destroy'               => true,
                'inventory.show'                       => true,
                'inventory.store'                      => true,
                'inventory.update'                     => true,
                'inventory.destroy'                    => true
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'event manager',
            'name'        => 'Event Manager',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => false,
                'conference.show'                      => true,
                'conference.update'                    => false,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => true,
                'event.update'                         => true,
                'event.status'                         => false,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => true,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => true,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => true,
                'conferenceVehicles.show'              => true,
                'conferenceVehicles.update'            => true,
                'conferenceVehicles.destroy'           => true,
                'eventVehicles.store'                  => true,
                'eventVehicles.show'                   => true,
                'eventVehicle.update'                  => true,
                'eventVehicle.destroy'                 => true,
                'accommodations.store'                 => true,
                'accommodations.show'                  => true,
                'accommodations.update'                => true,
                'accommodations.destroy'               => true,
                'inventory.show'                       => false,
                'inventory.store'                      => false,
                'inventory.update'                     => false,
                'inventory.destroy'                    => false,
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'accommodations manager',
            'name'        => 'Accommodations Manager',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => false,
                'conference.show'                      => true,
                'conference.update'                    => false,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => false,
                'event.show'                           => true,
                'event.update'                         => false,
                'event.status'                         => false,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => false,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => false,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => false,
                'conferenceVehicles.show'              => false,
                'conferenceVehicles.update'            => false,
                'conferenceVehicles.destroy'           => false,
                'eventVehicles.store'                  => false,
                'eventVehicles.show'                   => false,
                'eventVehicle.update'                  => false,
                'eventVehicle.destroy'                 => false,
                'accommodations.store'                 => true,
                'accommodations.show'                  => true,
                'accommodations.update'                => true,
                'accommodations.destroy'               => true,
                'inventory.show'                       => false,
                'inventory.store'                      => false,
                'inventory.update'                     => false,
                'inventory.destroy'                    => false
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'conference transportation manager',
            'name'        => 'Conference Transportation Manager',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => false,
                'conference.show'                      => true,
                'conference.update'                    => false,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => false,
                'event.show'                           => true,
                'event.update'                         => false,
                'event.status'                         => false,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => false,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => false,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => true,
                'conferenceVehicles.show'              => true,
                'conferenceVehicles.update'            => true,
                'conferenceVehicles.destroy'           => true,
                'eventVehicles.store'                  => true,
                'eventVehicles.show'                   => true,
                'eventVehicle.update'                  => true,
                'eventVehicle.destroy'                 => true,
                'accommodations.store'                 => false,
                'accommodations.show'                  => false,
                'accommodations.update'                => false,
                'accommodations.destroy'               => false,
                'inventory.show'                       => false,
                'inventory.store'                      => false,
                'inventory.update'                     => false,
                'inventory.destroy'                    => false,
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'event transportation manager',
            'name'        => 'Event Transportation Manager',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => false,
                'conference.show'                      => true,
                'conference.update'                    => false,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => false,
                'event.show'                           => true,
                'event.update'                         => false,
                'event.status'                         => false,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => false,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => true,
                'eventAttendees.update'                => false,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => false,
                'conferenceVehicles.show'              => false,
                'conferenceVehicles.update'            => false,
                'conferenceVehicles.destroy'           => false,
                'eventVehicles.store'                  => true,
                'eventVehicles.show'                   => true,
                'eventVehicle.update'                  => true,
                'eventVehicle.destroy'                 => true,
                'accommodations.store'                 => false,
                'accommodations.show'                  => false,
                'accommodations.update'                => false,
                'accommodations.destroy'               => false,
                'inventory.show'                       => false,
                'inventory.store'                      => false,
                'inventory.update'                     => false,
                'inventory.destroy'                    => false,
            ],
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'regular user',
            'name'        => 'Regular User',
            'permissions' => [
                'conference.status'                    => false,
                'conference.store'                     => false,
                'conference.show'                      => true,
                'conference.update'                    => false,
                'conference.destroy'                   => false,
                'user.update'                          => false,
                'role.store'                           => false,
                'role.update'                          => false,
                'role.destroy'                         => false,
                'event.store'                          => false,
                'event.show'                           => true,
                'event.update'                         => false,
                'event.status'                         => false,
                'event.destroy'                        => false,
                'conferenceAttendees.show'             => true,
                'conferenceAttendees.update'           => true,
                'conferenceAttendees.destroy'          => false,
                'eventAttendees.show'                  => false,
                'eventAttendees.update'                => false,
                'eventAttendees.destroy'               => false,
                'profile.show'                         => true,
                'profile.update'                       => true,
                'profile.destroy'                      => false,
                'conferenceVehicles.store'             => false,
                'conferenceVehicles.show'              => false,
                'conferenceVehicles.update'            => false,
                'conferenceVehicles.destroy'           => false,
                'eventVehicles.store'                  => false,
                'eventVehicles.show'                   => false,
                'eventVehicle.update'                  => false,
                'eventVehicle.destroy'                 => false,
                'accommodations.store'                 => false,
                'accommodations.show'                  => false,
                'accommodations.update'                => false,
                'accommodations.destroy'               => false,
                'inventory.show'                       => false,
                'inventory.store'                      => false,
                'inventory.update'                     => false,
                'inventory.destroy'                    => false,
            ],
        ]);
    }
}

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Register the user.
        $user = [
            'username' => 'admin',
            'password' => 'password',
        ];
        $user = \Sentinel::registerAndActivate($user);

        // Create the owner profile for the user.
        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->save();

        // Attach the System Administrator role to the user.
        $role = Sentinel::findRoleByName('System Administrator');
        $role->users()->attach($user);
    }
}

class ConferencesSeeder extends Seeder
{
    public function run()
    {
        $conference = [
            'name'        => 'India Conference',
            'description' => 'A conference in India.',
            'start_date'  => '2016-05-01',
            'end_date'    => '2016-05-10',
            'address'     => 'Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India',
            'city'        => 'New Delhi',
            'country'     => 'India',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-01',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => 'Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India',
            'city'         => 'New Delhi',
            'country'      => 'India',
            'age_limit'    => NULL,
            'gender_limit' => NULL,
            'capacity'     => 1000,
            'status'       => 'approved',
        ];

        $conference = Conference::create($conference);
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        $conference = [
            'name'        => 'Canada Conference',
            'description' => 'A conference in Canada.',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'        => 'Vancouver',
            'country'     => 'Canada',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-11',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'         => 'Vancouver',
            'country'      => 'Canada',
            'age_limit'    => NULL,
            'gender_limit' => NULL,
            'capacity'     => 1000,
            'status'       => 'approved',
        ];

        $conference = Conference::create($conference);
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        $conference = [
            'name'        => 'France Conference',
            'description' => 'A conference in France.',
            'start_date'  => '2016-05-21',
            'end_date'    => '2016-05-30',
            'address'     => '17 Boulevard Saint-Jacques, Paris 75014, France',
            'city'        => 'Paris',
            'country'     => 'France',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-21',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => '17 Boulevard Saint-Jacques, Paris 75014, France',
            'city'         => 'Paris',
            'country'      => 'France',
            'age_limit'    => NULL,
            'gender_limit' => NULL,
            'capacity'     => 1000,
            'status'       => 'approved',
        ];

        $conference = Conference::create($conference);
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();
    }
}
