<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

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

        DB::table('profiles')->truncate();
        DB::table('users')->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            User::create([
                'username' => $faker->unique()->userName,
                'email'    => $faker->unique()->email,
                'password' => Hash::make($faker->password),
            ]);
        }
    }
}

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $limit = 10;

        $gender = array('male', 'female');
        for ($i = 0; $i < $limit; $i++) {
            $profile = Profile::create([
                'user_id'    => $faker->unique()->numberBetween(1, 10),
                'is_owner'   => 1,
                'email'      => $faker->email,
                'phone'      => $faker->phoneNumber,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => $faker->country,
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => $gender[array_rand($gender)],
            ]);
        }
    }
}
