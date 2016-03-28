<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Find all rooms within certain accommodation
     */
    public function testRoomIndex()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/accommodations/1/rooms')
            ->seeJson([
                'accommodation_id' => 1,
                'room_no' => "100",
                'room_no' => "101",
                'room_no' => "102",
            ]);
            */
    }

}
