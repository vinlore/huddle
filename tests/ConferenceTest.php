<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConferenceTest extends TestCase{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
          $this->json('POST', '/api/conferences', ['name' => 'CONFERENCE 1'])
             ->seeJson([
                'status'  => 'success'
             ]);
    }
}
