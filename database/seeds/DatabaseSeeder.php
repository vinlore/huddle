<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\Models\Profile as Profile;
use App\Models\User as User;

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
        DB::table('profiles')->truncate();
        DB::table('users')->truncate();
        DB::table('role_users')->truncate();

        $this->call(RolesTableSeeder::class);
        $this->call(AdminUserSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}


class RolesTableSeeder extends Seeder
{

    public function run()
    {
        Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'system administrator',
            'name'   => 'System Administrator',
            'permissions'      => array( 
                                         "conference.status"                    => true,
                                         "conference.store"                     => true,
                                         "conference.show"                      => true,
                                         "conference.update"                    => true,
                                         "conference.destroy"                   => true,
                                         "user.update"                          => true,
                                         "role.store"                           => true,
                                         "role.update"                          => true,
                                         "role.destroy"                         => true,
                                         "event.store"                          => true,
                                         "event.show"                           => true,
                                         "event.update"                         => true,
                                         "event.status"                         => true,
                                         "event.destroy"                        => true,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => true,
                                         "conferenceAttendees.destroy"          => true,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => true,
                                         "eventAttendees.destroy"               => true,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => true,
                                         "conferenceVehicles.store"             => true,
                                         "conferenceVehicles.show"              => true,
                                         "conferenceVehicles.update"            => true,
                                         "conferenceVehicles.destroy"           => true,
                                         "eventVehicles.store"                  => true,
                                         "eventVehicles.show"                   => true,
                                         "eventVehicle.update"                  => true,
                                         "eventVehicle.destroy"                 => true,
                                         "accommodations.store"                 => true,
                                         "accommodations.show"                  => true,
                                         "accommodations.update"                => true,
                                         "accommodations.destroy"               => true
                                        )
        ]);

    Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'conference manager',
            'name'   => 'Conference Manager',
            'permissions'      => array( 
                                         "conference.status"                    => false,
                                         "conference.store"                     => true,
                                         "conference.show"                      => true,
                                         "conference.update"                    => true,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => true,
                                         "event.show"                           => true,
                                         "event.update"                         => true,
                                         "event.status"                         => true,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => true,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => true,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => true,
                                         "conferenceVehicles.show"              => true,
                                         "conferenceVehicles.update"            => true,
                                         "conferenceVehicles.destroy"           => true,
                                         "eventVehicles.store"                  => true,
                                         "eventVehicles.show"                   => true,
                                         "eventVehicle.update"                  => true,
                                         "eventVehicle.destroy"                 => true,
                                         "accommodations.store"                 => true,
                                         "accommodations.show"                  => true,
                                         "accommodations.update"                => true,
                                         "accommodations.destroy"               => true
                                         
                                        )
        ]); 

         Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'event manager',
            'name'   => 'Event Manager',
            'permissions'      => array( 
                                         "conference.status"                    => false,
                                         "conference.store"                     => false,
                                         "conference.show"                      => true,
                                         "conference.update"                    => false,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => true,
                                         "event.show"                           => true,
                                         "event.update"                         => true,
                                         "event.status"                         => false,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => true,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => true,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => true,
                                         "conferenceVehicles.show"              => true,
                                         "conferenceVehicles.update"            => true,
                                         "conferenceVehicles.destroy"           => true,
                                         "eventVehicles.store"                  => true,
                                         "eventVehicles.show"                   => true,
                                         "eventVehicle.update"                  => true,
                                         "eventVehicle.destroy"                 => true,
                                         "accommodations.store"                 => true,
                                         "accommodations.show"                  => true,
                                         "accommodations.update"                => true,
                                         "accommodations.destroy"               => true
                                        )
        ]);

    Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'accommodations manager',
            'name'   => 'Accommodations Manager',
            'permissions'      => array(  
                                         "conference.status"                    => false,
                                         "conference.store"                     => false,
                                         "conference.show"                      => true,
                                         "conference.update"                    => false,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => false,
                                         "event.show"                           => true,
                                         "event.update"                         => false,
                                         "event.status"                         => false,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => false,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => false,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => false,
                                         "conferenceVehicles.show"              => false,
                                         "conferenceVehicles.update"            => false,
                                         "conferenceVehicles.destroy"           => false,
                                         "eventVehicles.store"                  => false,
                                         "eventVehicles.show"                   => false,
                                         "eventVehicle.update"                  => false,
                                         "eventVehicle.destroy"                 => false,
                                         "accommodations.store"                 => true,
                                         "accommodations.show"                  => true,
                                         "accommodations.update"                => true,
                                         "accommodations.destroy"               => true
                                        )
        ]);

    Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'conference transportation manager',
            'name'   => 'Conference Transportation Manager',
            'permissions'      => array( 
                                         "conference.status"                    => false,
                                         "conference.store"                     => false,
                                         "conference.show"                      => true,
                                         "conference.update"                    => false,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => false,
                                         "event.show"                           => true,
                                         "event.update"                         => false,
                                         "event.status"                         => false,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => false,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => false,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => true,
                                         "conferenceVehicles.show"              => true,
                                         "conferenceVehicles.update"            => true,
                                         "conferenceVehicles.destroy"           => true,
                                         "eventVehicles.store"                  => true,
                                         "eventVehicles.show"                   => true,
                                         "eventVehicle.update"                  => true,
                                         "eventVehicle.destroy"                 => true,
                                         "accommodations.store"                 => false,
                                         "accommodations.show"                  => false,
                                         "accommodations.update"                => false,
                                         "accommodations.destroy"               => false
                                        )
        ]);

    Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'event transportation manager',
            'name'   => 'Event Transportation Manager',
            'permissions'      => array( 
                                         "conference.status"                    => false,
                                         "conference.store"                     => false,
                                         "conference.show"                      => true,
                                         "conference.update"                    => false,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => false,
                                         "event.show"                           => true,
                                         "event.update"                         => false,
                                         "event.status"                         => false,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => false,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => true,
                                         "eventAttendees.update"                => false,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => false,
                                         "conferenceVehicles.show"              => false,
                                         "conferenceVehicles.update"            => false,
                                         "conferenceVehicles.destroy"           => false,
                                         "eventVehicles.store"                  => true,
                                         "eventVehicles.show"                   => true,
                                         "eventVehicle.update"                  => true,
                                         "eventVehicle.destroy"                 => true,
                                         "accommodations.store"                 => false,
                                         "accommodations.show"                  => false,
                                         "accommodations.update"                => false,
                                         "accommodations.destroy"               => false
                                        )
        ]);

      Sentinel::getRoleRepository()->createModel()->create([
            'slug'    => 'regular user',
            'name'   => 'Regular User',
            'permissions'      => array( 
                                         "conference.status"                    => false,
                                         "conference.store"                     => false,
                                         "conference.show"                      => true,
                                         "conference.update"                    => false,
                                         "conference.destroy"                   => false,
                                         "user.update"                          => false,
                                         "role.store"                           => false,
                                         "role.update"                          => false,
                                         "role.destroy"                         => false,
                                         "event.store"                          => false,
                                         "event.show"                           => true,
                                         "event.update"                         => false,
                                         "event.status"                         => false,
                                         "event.destroy"                        => false,
                                         "conferenceAttendees.show"             => true,
                                         "conferenceAttendees.update"           => true,
                                         "conferenceAttendees.destroy"          => false,
                                         "eventAttendees.show"                  => false,
                                         "eventAttendees.update"                => false,
                                         "eventAttendees.destroy"               => false,
                                         "profile.show"                         => true,
                                         "profile.update"                       => true,
                                         "profile.destroy"                      => false,
                                         "conferenceVehicles.store"             => false,
                                         "conferenceVehicles.show"              => false,
                                         "conferenceVehicles.update"            => false,
                                         "conferenceVehicles.destroy"           => false,
                                         "eventVehicles.store"                  => false,
                                         "eventVehicles.show"                   => false,
                                         "eventVehicle.update"                  => false,
                                         "eventVehicle.destroy"                 => false,
                                         "accommodations.store"                 => false,
                                         "accommodations.show"                  => false,
                                         "accommodations.update"                => false,
                                         "accommodations.destroy"               => false
                                        )
        ]);

    }
        

}

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        
            $user = User::create([
                'username' => 'admin',
                'password' => 'password'
            ]);

            $user_id = $user->id;

              Profile::create([
                'user_id'    => $user_id,
                'is_owner'   => 1
            ]);

            DB::table('role_users')->insert([
                'user_id'   => $user_id,
                'role_id'   => 1
                ]);
        
    }


}