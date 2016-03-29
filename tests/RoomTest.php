<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Create a Room
     */
    public function testRoomCreate()
    {
        try{
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed');
            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());


            $room = [
                'accommodation_id' => 1,
                'room_no' => '410',
                'guest_count' => 5,
                'capacity' => 10,
            ];
            $this->call('POST', '/api/accommodations/1/rooms', $room, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
            $this->seeJson([
                'status' => 200
            ]);
       } catch(Exception $e) {
           echo $e->getMessage();
       }
    }

    // Finding all Rooms within accommodation 1
    public function testRoomShow()
    {
        $this->json('GET','/api/accommodations/1/rooms')
            ->seeJson([
                'room_no' => '410',
                'guest_count' => 5,
                'capacity' => 10,
            ]);
    }

    //Update Accommodation
    public function testRoomUpdate()
    {
        try{
            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());


            $room = [
                'accommodation_id' => 1,
                'room_no' => '500',
                'guest_count' => 6,
                'capacity' => 90,
            ];
            $this->call('PUT', '/api/accommodations/1/rooms/7', $room, [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
            $this->seeJson([
                'status' => 200
            ]);
       } catch(Exception $e) {
           echo $e->getMessage();
       }
    }

    // Finding all Rooms within accommodation 1
    public function testRoomShowUpdated()
    {
        $this->json('GET','/api/accommodations/1/rooms')
            ->seeJson([
                'room_no' => '500',
                'guest_count' => 6,
                'capacity' => 90,
            ]);
    }

    //Delete the newly inserted Room
    public function testDeleteRoom()
    {
        try{
            $response = $this->call('POST', '/api/auth/login', ['username' => 'admin', 'password' => 'password']);
            $content = json_decode($response->getContent());

            $this->call('DELETE', '/api/accommodations/1/rooms/7', [], [], [], ['HTTP_X-Auth-Token' => $content->token, 'HTTP_ID' => 1]);
            $this->seeJson([
                'status' => 200
            ]);
       } catch(Exception $e) {
           echo $e->getMessage();
       }
    }
}
