<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileAttendConferenceTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Get profile with certain id
     */
    public function testProfileShow()
    {
        $this->json('GET','/api/conferences/2/attendees/0')
            ->seeJson([
            'email' => 'admin@huddle.com',
            'phone' => '6040000111',
            'first_name' => 'Jane',
            'email' => 'hantino@huddle.com',
            'status' => 'approved',
            ]);
    }
}
