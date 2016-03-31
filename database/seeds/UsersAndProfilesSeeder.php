<?php

use Illuminate\Database\Seeder;

Use Faker\Factory as Faker;

use App\Models\Conference;
use App\Models\Profile;
use App\Models\User;

class UsersAndProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // USER 1
        // ---------------------------------------------------------------------

        $user = [
            'username'      => 'admin',
            'email'         => 'gabrielahernandez@hotmail.ca',
            'password'      => 'password',
            'receive_email' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('System Administrator');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
        // USER 2
        // ---------------------------------------------------------------------

        $user = [
            'username' => 'hantino',
            'email'    => 'hantino@huddle.com',
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
            'first_name' => 'Haniel',
            'last_name'  => 'Martino',
            'city'       => 'Vancouver',
            'country'    => 'Canada',
            'birthdate'  => '1993-01-01',
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
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'password'      => 'password',
            'receive_email' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Conference Manager');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'username' => 'jma92',
            'email'    => 'jma92@huddle.com',
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'username' => 'm4rtin.t',
            'email'    => 'm4rtin.t@huddle.com',
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'username' => 'chrisyang',
            'email'    => 'chrisyang@huddle.com',
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'   => 1,
            'email'      => $user->email,
            'phone'      => '6040000111',
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
            'is_owner'   => 0,
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
            'is_owner'   => 0,
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

        $faker = Faker::create();
        $user = Sentinel::findById(6);
        $conference = Conference::find(1);
        for ($i = 0; $i < 100; ++$i) {
            $profile = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => 'India',
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => 'male',
            ];
            $profile = new Profile($profile);
            $profile->user()->associate($user);
            $profile->save();
            $profile->conferences()->attach($conference->id, [
                'birthdate' => $profile->birthdate,
                'country'   => $profile->country,
                'gender'    => $profile->gender,
                'status'    => 'approved',
            ]);
            $conference->increment('attendee_count');
        }
        for ($i = 0; $i < 100; ++$i) {
            $profile = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => 'Canada',
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => 'male',
            ];
            $profile = new Profile($profile);
            $profile->user()->associate($user);
            $profile->save();
            $profile->conferences()->attach($conference->id, [
                'birthdate' => $profile->birthdate,
                'country'   => $profile->country,
                'gender'    => $profile->gender,
                'status'    => 'approved',
            ]);
            $conference->increment('attendee_count');
        }
        for ($i = 0; $i < 100; ++$i) {
            $profile = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => 'France',
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => 'female',
            ];
            $profile = new Profile($profile);
            $profile->user()->associate($user);
            $profile->save();
            $profile->conferences()->attach($conference->id, [
                'birthdate' => $profile->birthdate,
                'country'   => $profile->country,
                'gender'    => $profile->gender,
                'status'    => 'approved',
            ]);
            $conference->increment('attendee_count');
        }
        for ($i = 0; $i < 100; ++$i) {
            $profile = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => 'United States',
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => 'female',
            ];
            $profile = new Profile($profile);
            $profile->user()->associate($user);
            $profile->save();
            $profile->conferences()->attach($conference->id, [
                'birthdate' => $profile->birthdate,
                'country'   => $profile->country,
                'gender'    => $profile->gender,
                'status'    => 'approved',
            ]);
            $conference->increment('attendee_count');
        }
    }
}

