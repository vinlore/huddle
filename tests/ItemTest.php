<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ItemTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    private $ATTRIBUTES = [
        'id',
        'conference_id',
        'name',
        'quantity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function testIndex()
    {
        $this->get('/api/conferences/4/inventory');
        $this->seeJsonStructure([
            '*' => $this->ATTRIBUTES
        ]);
    }
}
