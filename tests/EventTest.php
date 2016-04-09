<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Models\Event;

class EventTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    private $ATTRIBUTES = [
        'id',
        'conference_id',
        'name',
        'description',
        'facilitator',
        'date',
        'start_time',
        'end_time',
        'address',
        'city',
        'country',
        'age_limit',
        'gender_limit',
        'attendee_count',
        'capacity',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    private $TEST_DATA = [
        'name'         => 'Test Event',
        'description'  => 'For testing purposes.',
        'facilitator'  => 'Tester',
        'date'         => '3000-01-01',
        'start_time'   => '08:00:00',
        'end_time'     => '09:00:00',
        'address'      => 'localhost:8000',
        'city'         => 'Vancouver',
        'country'      => 'Canada',
        'capacity'     => 100,
    ];

    public function testIndexWithStatus()
    {
        $this->get('/api/events/status/approved');
        $this->seeJsonStructure([
            '*' => $this->ATTRIBUTES
        ]);
    }
}
