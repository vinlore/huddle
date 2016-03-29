<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileAttendConferenceTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Get profile with certain id
     */
    /*
    public function testProfileShow()
    {
        $this->assertTrue(true);

        $this->json('GET','/api/conferences/2/attendees/0')
            ->seeJson([
            'email' => 'admin@huddle.com',
            'phone' => '6040000111',
            'first_name' => 'Jane',
            'email' => 'hantino@huddle.com',
            'status' => 'approved',
            ]);

    } */

/*

    public function testConferenceAttendeeCreate(){
        try{
          Artisan::call('migrate:refresh');
          Artisan::call('db:seed');

           $attendee = [
            'email'             => 'Test Attendee',
            'profile_id'        => 1,
            'conference_id'     => 4,
            'phone'             => 'test',
            'first_name'        => "Test",
            'middle_name'       =>'test',
            'last_name'         => 'test',
            'city'              => 'test',
            'country'           => 'test',
            'birthdate'         => 000000,
            'gender'            => 'male',
            'accommodation_req' => false,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'pending',
        ];

            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());
            $this->call('POST', '/api/conferences/4/attendees',$attendee, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
            $this->seeJson([
                 'status'  => 200
              ]) ;

         }catch(Exception $e){
          echo $e->getMessage();
         }

    } */


    public function testProfileConferenceStatusUpdate(){

       $attendee = [
            'email'             => 'test@attendee.com',
            'profile_id'        => 1,
            'conference_id'     => 4,
            'phone'             => 0001112222,
            'first_name'        => "Test",
            'middle_name'       =>'test',
            'last_name'         => 'test',
            'city'              => 'test',
            'country'           => 'test',
            'birthdate'         => '2011-05-11',
            'gender'            => 'male',
            'accommodation_req' => false,
            'arrv_ride_req'     => false,
            'dept_ride_req'     => false,
            'status'            => 'approved',
        ];

            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());
            $this->call('PUT', '/api/conferences/4/attendees/1',$attendee, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
            $this->seeJson([
                 'status'  => 200
              ]);
    }

}
