<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileAttendEventTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Get profile with certain id
     */
    public function testProfileShow()
    {
        $this->json('GET','/api/profile/1/event/0')
            ->seeJson([
            'email' => 'admin@huddle.com',
            'phone' => '6040000111',
            'first_name' => 'Jane',
            'status' => 'pending',
            ]);
    }
}
