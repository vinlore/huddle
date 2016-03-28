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
        $this->json('GET','/api/conferences/2/profiles')
            ->seeJson([
                'email' => 'admin@huddle',
                'email' => 'hantino@huddle',
            ]);
    }
}
