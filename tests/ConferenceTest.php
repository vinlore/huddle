<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ConferenceTest extends TestCase{

    use WithoutMiddleware;


    public function testConferenceCreate(){
        try{
          Artisan::call('migrate:refresh');
          Artisan::call('db:seed');

          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $conference = [
            'name'        => 'Test Conference',
            'description' => 'A conference in Hong Kong.',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'        => 'Vancouver',
            'country'     => 'Canada',
            'capacity'    => 1000,
          ];
         $this->call('POST', '/api/conferences', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
         $this->seeJson([
                 'status'  => 200
              ]) ;

         }catch(Exception $e){
          echo $e->getMessage();
         }

    }

    /*
    * Finding above Conference that is pending
    */
    public function testIndexWithStatusPending()
    {
        $this->json('GET','/api/conferences/status/pending')
            ->seeJson([
                'name' => 'Test Conference',
                'status' => 'pending',
                'description' => 'A conference in Hong Kong.'
            ]);
    }

    /*
    * Changning information of conference 1
    */
    public function testConferenceUpdate(){
      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

           $conference = [
            'name'        => 'CHANGED',
            'description' => 'CHANGED',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => 'CHANGED',
            'city'        => 'CHANGED',
            'country'     => 'CHANGED',
            'capacity'    => 10
          ];

          $this->call('PUT', '/api/conferences/5', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }
    }

    /*
    * Check if above conference has actually changed
    */
    public function testFindConferenceUpdate()
    {
        $this->json('GET','/api/conferences/5')
            ->seeJson([
                'name'        => 'CHANGED',
                'description' => 'CHANGED',
                'start_date'  => '2016-05-11',
                'end_date'    => '2016-05-20',
            ]);
    }

    /*
    *   Updating Conference with changing status
    */
    public function testConferenceUpdateWithStatus(){

      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

            $conference = [
            'name'        => 'CHANGED',
            'description' => 'CHANGED',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => 'CHANGED',
            'city'        => 'CHANGED',
            'country'     => 'CHANGED',
            'capacity'    => 10,
            'status'      =>'denied'
          ];


         $response= $this->call('PUT','/api/conferences/5', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }

    /*
    * Check if above conference has actually changed the status
    */
    public function testFindConferenceUpdateStatus()
    {
        $this->json('GET','/api/conferences/5')
            ->seeJson([
                'name'        => 'CHANGED',
                'description' => 'CHANGED',
                'start_date'  => '2016-05-11',
                'end_date'    => '2016-05-20',
                'status'      => 'denied'
            ]);
    }


    public function testConferenceIndexWithStatus(){
      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $response = $this->call('GET','/api/conferences/status/approved', ['status'=>'approved'], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
              'country' => 'Canada',
              'country' => 'India',
              'country' => 'France',
             ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }


    public function testConferenceDestroy(){
      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $this->call('DELETE','/api/conferences/5', [], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }

}
