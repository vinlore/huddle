<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Indexing Controller.
     *
     * @return void
     */
    public function testEventIndex()
    {
        $this->json('GET','/api/conferences/1/events')
            ->seeJson([
                'id' => 1,
                'conference_id' => 1,
                'name' => "Opening Ceremony",
                'date' => '2016-05-01',
            ]);
    }

    public function testIndexWithStatusPending()
    {
        $this->json('GET','/api/events-status',
                        ['status' => 'pending'])
            ->seeJson([
                'id' => 1,
                'conference_id' => 1,
                'name' => 'Opening Ceremony',
                'date' => '2016-05-01',
                'status' => 'pending'
            ]);
    }

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
