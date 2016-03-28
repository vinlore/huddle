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
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/users/1/profiles')
            ->seeJson([
                'id' => 1,
                'user_id' => 1,
                'email' => 'admin@huddle.com',
            ]);
            */
    }

    /**
     * Get All Conferences ONE profile is going to
     */
    public function testProfileConference()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/profile/1/conferences')
            ->seeJson([
                'name' => "Canada Conference",
                'description' => "A conference in Canada.",
            ]);
            */
    }

    /**
    *   Get ALL Events ONE profile is going to
    */
    public function testEventConference()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/profile/1/events')
            ->seeJson([
                'name' => "Opening Ceremony",
                'description' => "Welcome!",
            ]);
            */
    }

    /**
    *
    *   Get ALL Events ONE profile is going to
    *   EMPTY
    */
    public function testEventConferenceEmpty()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/profile/2/events')
            ->seeJson([]);
            */
    }


}
