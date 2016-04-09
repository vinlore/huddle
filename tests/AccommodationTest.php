<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommodationTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    private $ATTRIBUTES = [
        'id',
        'conference_id',
        'name',
        'address',
        'city',
        'country',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function testIndex()
    {
        $this->get('/api/conferences/1/accommodations');
        $this->seeJsonStructure(['*' => $this->ATTRIBUTES]);
    }
}
