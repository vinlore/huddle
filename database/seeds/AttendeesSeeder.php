<?php

use Illuminate\Database\Seeder;

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
        // CONFERENCE 2
        // ---------------------------------------------------------------------

        $conference = Conference::find(2);

        $profile = Profile::find(1);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(2);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(3);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(4);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(5);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(6);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);

        $profile = Profile::find(7);
        $attendee = [
            'email'             => $profile->email,
            'phone'             => $profile->phone,
            'first_name'        => $profile->first_name,
            'middle_name'       => $profile->middle_name,
            'last_name'         => $profile->last_name,
            'city'              => $profile->city,
            'country'           => $profile->country,
            'birthdate'         => $profile->birthdate,
            'gender'            => $profile->gender,
            'accommodation_req' => true,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];
        $profile->conferences()->attach($conference->id, $attendee);
    }
}
