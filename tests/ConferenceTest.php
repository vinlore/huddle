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
            'description' => 'A conference in Canada.',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'        => 'Vancouver',
            'country'     => 'Canada',
            'capacity'    => 1000,
            'status'      => 'pending'
          ];
         $this->call('POST', '/api/conferences', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
         $this->seeJson([
                 'status'  => 200
              ]) ;

         }catch(Exception $e){
          echo $e->getMessage();
         }

    }

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

          $this->call('PUT', '/api/conferences/1', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }
    }


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


         $response= $this->call('PUT','/api/conferences/4', $conference, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }


    public function testConferenceIndexWithStatus(){


      try{
          $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
          $content = json_decode($response->getContent());

          $response = $this->call('GET','/api/conferences/status/approved', ['status'=>'approved'], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
              'country' => 'Canada'
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

          $this->call('DELETE','/api/conferences/4', [], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1 ]);
          $this->seeJson([
                 'status'  => 200
              ]);
        }catch(Exception $e){
          echo '---------';
          echo $e->getMessage();
        }

    }

}
