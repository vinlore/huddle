<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AccommodationTest extends TestCase{

     use WithoutMiddleware;

     /**
     *  Create an accomodation and assign it to conference 1
     **/
     public function testAccommodationCreate() {
         try{
             Artisan::call('migrate:refresh');
             Artisan::call('db:seed');

             $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
             $content = json_decode($response->getContent());

             $accommodation = [
                 'name' => 'Test Accommodation',
                 'address' => 'Test Address',
                 'city' => 'Test City',
                 'country' => 'Test Country',
             ];
             $this->call('POST', '/api/conferences/1/accommodations', $accommodation, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
             $this->seeJson([
                 'status' => 200
             ]);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }


    // Finding all accomodations for Conference 1

    public function testAccommodationShow()
    {
        $this->json('GET','/api/conferences/1/accommodations')
            ->seeJson([
                'name' => 'Test Accommodation',
            ]);
    }

    //Update the newly inserted Accomodation linked to conference 1
    public function testUpdateAccommodation()
    {
        try{
            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());

            $accommodation = [
                'name' => 'Change Accommodation',
                'address' => 'Change Address',
                'city' => 'Change City',
                'country' => 'Change Country',
            ];
            $this->call('PUT', '/api/conferences/3/accommodations/0', $accommodation, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
            $this->seeJson([
                'status' => 200
            ]);
       } catch(Exception $e) {
           echo $e->getMessage();
       }
    }

    // Find the Updated Accommodation

    public function testUpdatedAccommodationShow()
    {
        $this->json('GET','/api/conferences/3/accommodations/0')
            ->seeJson([
                'name' => 'Change Accommodation',
                'address' => 'Change Address',
            ]);
    }


    //Delete the newly inserted Accomodation linked to conference 1
    public function testDeleteAccommodation()
    {
        try{
            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());

            $this->call('DELETE', '/api/conferences/1/accommodations', [], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
            $this->seeJson([
                'status' => 200
            ]);
       } catch(Exception $e) {
           echo $e->getMessage();
       }
    }
/*
    //Try to find the deleted Accomodation
    public function testFindDeletedAccommodation()
    {
        $this->json('GET','/api/conferences/1/accommodations')
            ->seeJson([]);
    }
*/
}
