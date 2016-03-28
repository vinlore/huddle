<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Get profile with certain id
     */
    public function testProfileIndex()
    {
        $this->json('GET','/api/users/1/profiles')
            ->seeJson([
                'id' => 1,
                'user_id' => 1,
                'email' => 'admin@huddle.com',
            ]);
    }

    /**
     * Get All Conferences ONE profile is going to
     */
    public function testProfileConference()
    {
        $this->json('GET','/api/profile/1/conferences')
            ->seeJson([
                'name' => "Canada Conference",
                'description' => "A conference in Canada.",
            ]);
    }


}
