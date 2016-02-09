<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Attendee;

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Model::unguard();
            
        // Call the seed classes to run the seeds
        //$this->call('UsersTableSeeder');
        $this->call('AttendeesTableSeeder');
    }

}

class UsersTableSeeder extends Seeder {

    public function run()
    {
            
        // We want to delete the users table if it exists before running the seed
        DB::table('users')->delete();

        $users = array(
                ['username' => 'rchenkie', 'email' => 'ryanchenkie@gmail.com', 'password' => Hash::make('secret')],
                ['username' => 'csevilleja', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret')],
                ['username' => 'hlloyd', 'email' => 'holly@scotch.io', 'password' => Hash::make('secret')],
                ['username' => 'akukic', 'email' => 'adnan@scotch.io', 'password' => Hash::make('secret')],
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}

class AttendeesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('attendees')->delete();

        $attendees = array(
                ['user_id' => 1, 'first_name' => 'Ryan', 'middle_name' => '', 'last_name' => 'Chenkie', 'age' => 25, 'city' => 'Vancouver', 'country' => 'Canada',
                'arrival_ride_req' => True, 'arrival_date_time' => '2016-02-08T09:00:00Z', 'arrival_airport' => 'DEL','arrival_flight_num' => 'CZ330', 'depart_ride_req' => True,
                'depart_date_time' => '2016-02-10T14:40:00Z', 'depart_airport' => 'DEL', 'depart_flight_num' => 'CZ360', 'home_phone' => '(604) 123-4567', 'india_phone' => '(91-120) 4844644',
                'email' => 'ryanchenkie@gmail.com', 'emergency_contact' => 'James', 'emergency_contact_phone' => '(778) 987-6543', 'medical_conditions' => '']
        );

        foreach($attendees as $attendee)
        {
            Attendee::create($attendee); 
        }   

    }
}
