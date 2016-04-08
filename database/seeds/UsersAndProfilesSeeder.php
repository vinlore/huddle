<?php

use Illuminate\Database\Seeder;

use App\Models\Profile;

class UsersAndProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SYSTEM_ADMINISTRATOR = Sentinel::findRoleByName('System Administrator');
        $CONFERENCE_MANAGER = Sentinel::findRoleByName('Conference Manager');
        $EVENT_MANAGER = Sentinel::findRoleByName('Event Manager');
        $REGULAR_USER = Sentinel::findRoleByName('Regular User');

        // ---------------------------------------------------------------------
        // USER 1
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'admin',
            'email'    => 'admin@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $SYSTEM_ADMINISTRATOR;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'System',
            'last_name'  => 'Administrator',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 2
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'haniel',
            'email'    => 'haniel@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'Haniel',
            'last_name'  => 'Martino',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // UESR 3
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'viggy',
            'email'    => 'viggy@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'Vincent',
            'last_name'  => 'Lore',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1993-02-08',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 4
        // ---------------------------------------------------------------------

        $user = [
            'username'      => 'gabby',
            'email'         => 'gabby@huddle.com',
            'password'      => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'Gabriela',
            'last_name'  => 'Hernandez',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1993-02-16',
            'gender'     => 'female',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 5
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'james',
            'email'    => 'james@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'James',
            'last_name'  => 'Ma',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1992-01-23',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 6
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'martin',
            'email'    => 'martin@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'Martin',
            'last_name'  => 'Tsang',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1993-05-15',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 7
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'chris',
            'email'    => 'chris@huddle.com',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $CONFERENCE_MANAGER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'Christopher',
            'last_name'  => 'Yang',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1993-08-21',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        // ---------------------------------------------------------------------
        // USER 8
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'john',
            'email'    => 'john@example.org',
            'password' => 'password1',
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = $REGULAR_USER;
        $role->users()->attach($user);
        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => true,
            'email'      => $user->email,
            'phone'      => '6041234567',
            'first_name' => 'John',
            'last_name'  => 'Smith',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1980-01-01',
            'gender'     => 'male',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        $profile = [
            'first_name' => 'Mary',
            'last_name'  => 'Smith',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1980-01-01',
            'gender'     => 'female',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        $profile = [
            'first_name' => 'Alice',
            'last_name'  => 'Smith',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '2006-01-01',
            'gender'     => 'female',
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();
    }
}

