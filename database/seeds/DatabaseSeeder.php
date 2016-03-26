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
        $this->call(AccommodationsSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}

class RolesSeeder extends Seeder
{
    public function run()
    {
        $fullAccess = [
            'accommodation.store'         => true,
            'accommodation.show'          => true,
            'accommodation.update'        => true,
            'accommodation.destroy'       => true,

            'conference.status'           => true,
            'conference.store'            => true,
            'conference.show'             => true,
            'conference.update'           => true,
            'conference.destroy'          => true,

            'conference_attendee.status'  => true,
            'conference_attendee.store'   => true,
            'conference_attendee.show'    => true,
            'conference_attendee.update'  => true,
            'conference_attendee.destroy' => true,

            'conference_vehicle.store'    => true,
            'conference_vehicle.show'     => true,
            'conference_vehicle.update'   => true,
            'conference_vehicle.destroy'  => true,

            'event.status'                => true,
            'event.store'                 => true,
            'event.show'                  => true,
            'event.update'                => true,
            'event.destroy'               => true,

            'event_attendee.status'       => true,
            'event_attendee.store'        => true,
            'event_attendee.show'         => true,
            'event_attendee.update'       => true,
            'event_attendee.destroy'      => true,

            'event_vehicle.store'         => true,
            'event_vehicle.show'          => true,
            'event_vehicle.update'        => true,
            'event_vehicle.destroy'       => true,

            'item.store'                  => true,
            'item.show'                   => true,
            'item.update'                 => true,
            'item.destroy'                => true,

            'profile.store'               => true,
            'profile.show'                => true,
            'profile.update'              => true,
            'profile.destroy'             => true,

            'role.store'                  => true,
            'role.show'                   => true,
            'role.update'                 => true,
            'role.destroy'                => true,

            'room.store'                  => true,
            'room.show'                   => true,
            'room.update'                 => true,
            'room.destroy'                => true,

            'user.store'                  => true,
            'user.show'                   => true,
            'user.update'                 => true,
            'user.destroy'                => true,

            'vehicle.store'               => true,
            'vehicle.show'                => true,
            'vehicle.update'              => true,
            'vehicle.destroy'             => true,
        ];

        $limitedAccess = [
            'accommodation.store'         => false,
            'accommodation.show'          => false,
            'accommodation.update'        => false,
            'accommodation.destroy'       => false,

            'conference.status'           => false,
            'conference.store'            => false,
            'conference.show'             => true,
            'conference.update'           => false,
            'conference.destroy'          => false,

            'conference_attendee.status'  => false,
            'conference_attendee.store'   => false,
            'conference_attendee.show'    => true,
            'conference_attendee.update'  => true,
            'conference_attendee.destroy' => false,

            'conference_vehicle.store'    => false,
            'conference_vehicle.show'     => false,
            'conference_vehicle.update'   => false,
            'conference_vehicle.destroy'  => false,

            'event.status'                => false,
            'event.store'                 => false,
            'event.show'                  => true,
            'event.update'                => false,
            'event.destroy'               => false,

            'event_attendee.status'       => false,
            'event_attendee.store'        => false,
            'event_attendee.show'         => true,
            'event_attendee.update'       => true,
            'event_attendee.destroy'      => false,

            'event_vehicle.store'         => false,
            'event_vehicle.show'          => false,
            'event_vehicle.update'        => false,
            'event_vehicle.destroy'       => false,

            'item.store'                  => false,
            'item.show'                   => false,
            'item.update'                 => false,
            'item.destroy'                => false,

            'profile.store'               => true,
            'profile.show'                => true,
            'profile.update'              => true,
            'profile.destroy'             => true,

            'role.store'                  => false,
            'role.show'                   => false,
            'role.update'                 => false,
            'role.destroy'                => false,

            'room.store'                  => false,
            'room.show'                   => false,
            'room.update'                 => false,
            'room.destroy'                => false,

            'user.store'                  => false,
            'user.show'                   => true,
            'user.update'                 => true,
            'user.destroy'                => false,

            'vehicle.store'               => false,
            'vehicle.show'                => false,
            'vehicle.update'              => false,
            'vehicle.destroy'             => false,
        ];

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'system administrator',
            'name'        => 'System Administrator',
            'permissions' => $fullAccess,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'conference manager',
            'name'        => 'Conference Manager',
            'permissions' => $fullAccess,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'event manager',
            'name'        => 'Event Manager',
            'permissions' => $fullAccess,
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'slug'        => 'regular user',
            'name'        => 'Regular User',
            'permissions' => $limitedAccess,
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

class AccommodationsSeeder extends Seeder
{
    public function run()
    {
        $accommodation = [
            'name'          => 'Hotel-1',
            'address'       => '1128 West Georgia Street',
            'city'          => 'Vancouver',
            'country'       => 'Canada'
        ];

        $room1 = [
            'room_no'       => "1000",
            'guest_count'   => 0,
            'capacity'      => 2
        ];

        $room2 = [
            'room_no'       => "1001",
            'guest_count'   => 1,
            'capacity'      => 2
        ];

        $room3 = [
            'room_no'       => "1002",
            'guest_count'   => 2,
            'capacity'      => 2
        ];

        $accommodation = Accommodation::create($accommodation);
        $accommodation->conferences()->attach(Conference::find(2));

        $room = new Room($room1);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = new Room($room2);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = new Room($room3);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $accommodation = [
            'name'          => 'Hotel-2',
            'address'       => '5911 Minoru Blvd',
            'city'          => 'Richmond',
            'country'       => 'Canada'
        ];

        $room1 = [
            'room_no'       => "A250",
            'guest_count'   => 0,
            'capacity'      => 2
        ];

        $room2 = [
            'room_no'       => "B350",
            'guest_count'   => 4,
            'capacity'      => 4
        ];

        $room3 = [
            'room_no'       => "C450",
            'guest_count'   => 2,
            'capacity'      => 3
        ];

        $accommodation = Accommodation::create($accommodation);
        $accommodation->conferences()->attach(Conference::find(2));

        $room = new Room($room1);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = new Room($room2);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = new Room($room3);
        $room->accommodation()->associate($accommodation);
        $room->save();
    }
}
