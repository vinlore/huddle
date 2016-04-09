<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Models\Conference;

class ConferenceTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    private $ATTRIBUTES = [
        'id',
        'name',
        'description',
        'start_date',
        'end_date',
        'address',
        'city',
        'country',
        'attendee_count',
        'capacity',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    private $TEST_DATA = [
        'name'        => 'Test Conference',
        'description' => 'For testing purposes.',
        'start_date'  => '3000-01-01',
        'end_date'    => '3000-01-31',
        'address'     => 'localhost',
        'city'        => 'Vancouver',
        'country'     => 'Canada',
        'capacity'    => 100,
    ];

    public function testIndex()
    {
        $this->get('/api/conferences');
        $this->assertResponseStatus(403);
    }

    public function testStore()
    {
        $this->login($this->ADMIN);

        $this->post('/api/conferences', $this->TEST_DATA, $this->header);
        $this->assertResponseOk();
        $this->seeInDatabase('conferences', $this->TEST_DATA);

        $cid = Conference::where('name', $this->TEST_DATA['name'])->first()->getKey();
        $this->get('/api/conferences/'.$cid);
        $this->seeJson($this->TEST_DATA);

        $this->get('/api/conferences/'.$cid.'/managers');
        $this->seeJson(['username' => 'admin']);

        $this->logout();
    }

    public function testIndexWithStatus()
    {
        $this->get('/api/conferences/status/approved');
        $this->seeJsonStructure([
            '*' => $this->ATTRIBUTES
        ]);
    }
}
