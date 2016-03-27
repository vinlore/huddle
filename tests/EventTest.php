<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Finding all events within conference 4
     *
     * @return void
     */
    public function testEventIndex()
    {
        $this->json('GET','/api/conferences/4/events')
            ->seeJson([
                'conference_id' => 4,
                'name' => "Project 2 Final Demos",

                'name' => 'Project 3 Final Demos',

                'name' => 'Project 1 Final Demos',

            ]);
    }

    /*
    * Finding all events that are pending
    */
    public function testIndexWithStatusPending()
    {
        $this->json('GET','/api/events-status',
                        ['status' => 'pending'])
            ->seeJson([
                'conference_id' => 4,
                'name' => 'Project 2 Final Demos',
                'status' => 'pending',
                'description' => 'Teams 5 to 8 present their projects.',

                'name' => 'Project 3 Final Demos',
                'description' => 'Teams 9 to 12 present their projects.',
            ]);
    }

    /*
    * Finding all events that are approved
    */
    public function testIndexWithStatusApproved()
    {
        $this->json('GET','/api/events-status',
                        ['status' => 'approved'])
            ->seeJson(
            [
                'conference_id' => 2,
                'address' => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',

                'conference_id' => 3,
                'address' => '17 Boulevard Saint-Jacques, Paris 75014, France',
                'status' => 'approved',
            ]);
    }

}
