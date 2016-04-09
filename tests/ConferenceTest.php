<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Models\Conference;

class ConferenceTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    private $CONFERENCE_FIELDS = [
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

    private $TEST_CONFERENCE = [
        'name'        => 'Test Conference',
        'description' => 'For testing purposes.',
        'start_date'  => '3000-01-01',
        'end_date'    => '3000-01-31',
        'address'     => 'localhost',
        'city'        => 'Vancouver',
        'country'     => 'Canada',
        'capacity'    => 1,
    ];

    /**
     * Check that indexing conferences via URI is unavailable.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->json('GET', '/api/conferences');
        $this->assertResponseStatus(403);
    }

    /**
     * Check that creating a conference works.
     *
     * @return void
     */
    public function testStore()
    {
        $this->login($this->ADMIN);

        $this->post('/api/conferences', $this->TEST_CONFERENCE, $this->header);
        $this->assertResponseOk();
        $this->seeInDatabase('conferences', $this->TEST_CONFERENCE);

        $cid = Conference::where('name', $this->TEST_CONFERENCE['name'])->first()->getKey();
        $this->get('/api/conferences/'.$cid);
        $this->seeJson($this->TEST_CONFERENCE);

        $this->get('/api/conferences/'.$cid.'/managers');
        $this->seeJson(['username' => 'admin']);

        $this->logout();
    }

    /**
     * Check the structure of Conference objects.
     *
     * @return void
     */
    public function testIndexWithStatus()
    {
        $this->json('GET', '/api/conferences/status/approved');
        $this->assertResponseOk();
        $this->seeJsonStructure(['*' => $this->CONFERENCE_FIELDS]);
    }
}
