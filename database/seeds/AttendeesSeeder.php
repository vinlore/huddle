<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Conference;
use App\Models\Profile;

class AttendeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // CONFERENCE 1
        // ---------------------------------------------------------------------

        $faker = Faker::create();

        $user = Sentinel::findById(6);
        $conference = Conference::find(1);

        $countries = [
            'Canada',
            'France',
            'India',
            'United States',
        ];

        $genders = [
            'female',
            'male',
        ];

        for ($i = 0; $i < 100; ++$i) {
            $profile = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'city'       => $faker->city,
                'country'    => $countries[rand(0, 3)],
                'birthdate'  => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender'     => $genders[rand(0, 1)],
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

        // ---------------------------------------------------------------------
        // CONFERENCE 2
        // ---------------------------------------------------------------------

        $conference = Conference::find(2);
        $event = $conference->events()->first();
        $room = $conference->accommodations()->first()->rooms()->first();
        $conferenceVehicle = $conference->vehicles()->first();
        $eventVehicle = $event->vehicles()->first();

        for ($i = 1; $i <= 7; ++$i) {
            $profile = Profile::find($i);
            $attendee = [
                'email'              => $profile->email,
                'phone'              => $profile->phone,
                'first_name'         => $profile->first_name,
                'middle_name'        => $profile->middle_name,
                'last_name'          => $profile->last_name,
                'city'               => $profile->city,
                'country'            => $profile->country,
                'birthdate'          => $profile->birthdate,
                'gender'             => $profile->gender,
                'accommodation_req'  => true,
                'accommodation_pref' => 1,
                'arrv_ride_req'      => true,
                'arrv_date'          => '2016-04-08',
                'arrv_time'          => '21:30',
                'arrv_airport'       => 'DEL',
                'arrv_flight'        => 'AC2273',
                'dept_ride_req'      => false,
                'status'             => 'approved',
            ];
            $profile->conferences()->attach($conference, $attendee);
            $conference->increment('attendee_count');
            $profile->events()->attach($event);
            $profile->rooms()->attach($room);
            $room->increment('guest_count');
            $profile->conferenceVehicles()->attach($conferenceVehicle);
            $conferenceVehicle->increment('passenger_count');
            $profile->eventVehicles()->attach($eventVehicle);
            $eventVehicle->increment('passenger_count');
        }
    }
}
