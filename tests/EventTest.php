<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Finding all events within conference 4
     *
     * @return void
     */
    public function testEventIndex()
    {
          Artisan::call('migrate:refresh');
          Artisan::call('db:seed');
        $this->json('GET','/api/conferences/4/events')
            ->seeJson([
                'conference_id' => 4,
                'name' => "Project 2 Final Demos",

                'name' => 'Project 3 Final Demos',

                'name' => 'Project 1 Final Demos',

            ]);
    }

    /*

    /*
    * Finding all events that are pending
    */
    /*
    public function testIndexWithStatusPending()
    {
        $this->json('GET','/api/events-status',
                        ['status' => 'pending'])
            ->seeJson([
                'conference_id' => 4,
                'name' => 'Project 2 Final Demos',
                'status' => 'pending',
                'description' => 'Teams 5 to 8 present their projects.',

                'name' => 'Project 3 Final Demos',
                'description' => 'Teams 9 to 12 present their projects.',
            ]);
    }*/

    /*
    * Finding all events that are approved
    */
    /*
    public function testIndexWithStatusApproved()
    {
        $this->json('GET','/api/events-status',
                        ['status' => 'approved'])
            ->seeJson(
            [
                'conference_id' => 2,
                'address' => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',

                'conference_id' => 3,
                'address' => '17 Boulevard Saint-Jacques, Paris 75014, France',
                'status' => 'approved',
            ]);
    }   */

     public function testEventCreate(){
        try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

           $event = [
            'name'         => 'Test Event',
            'conference_id' => 4,
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-01',
            'start_time'   => '09:00',
            'end_time'     => '10:00',
            'address'      => 'Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India',
            'city'         => 'New Delhi',
            'country'      => 'India',
            'capacity'     => 1000,
            'status'       => 'pending'
        ];
        $this->call('POST', '/api/conferences/4/events', $event, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
        $this->seeJson([
                 'status'  => 200
              ]) ;
         }catch(Exception $e){
          echo $e->getMessage();
         }

    }


    public function testEventUpdate(){
      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

             $event = [
            'name'         => 'CHANGED',
            'conference_id' => 4,
            'description'  => 'CHANGED',
            'facilitator'  => 'CHANGED',
            'date'         => '2016-05-01',
            'start_time'   => '09:00',
            'end_time'     => '10:00',
            'address'      => 'CHANGED',
            'city'         => 'CHANGED',
            'country'      => 'CHANGED',
            'capacity'     => 1000
        ];

          $this->call('PUT', '/api/conferences/1/events/4', $event, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }
    }


    public function testEventUpdateWithStatus(){

      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $event = [
            'name'         => 'CHANGED',
            'conference_id' => 4,
            'description'  => 'CHANGED',
            'facilitator'  => 'CHANGED',
            'date'         => '2016-05-01',
            'start_time'   => '09:00',
            'end_time'     => '10:00',
            'address'      => 'CHANGED',
            'city'         => 'CHANGED',
            'country'      => 'CHANGED',
            'capacity'     => 1000,
            'status'       => 'denied'
        ];


         $this->call('PUT','/api/conferences/4/events/4', $event, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
         $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }


    public function testEvetIndexWithStatus(){


      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $this->call('GET','/api/events/pending', ['status'=>'approved'], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
              'country' => 'Canada'
             ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }


    public function testEventDestroy(){
      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $this->call('DELETE','/api/conferences/4/events/4', [], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }

}
