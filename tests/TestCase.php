<?php

use Illuminate\Support\Facades\Artisan;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Default System Administrator credentials.
     *
     * @var array
     */
    protected $ADMIN = [
        'username' => 'admin',
        'password' => 'password1',
    ];

    /**
     * User credentials.
     *
     * @var array
     */
    protected $header = [
        'HTTP_X-Auth-Token' => NULL,
        'HTTP_ID'           => NULL,
    ];

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    /**
     * Seed the testing database during setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * Log in with a set of user credentials and retrieve information for header.
     *
     * @return void
     */
    protected function login($credentials)
    {
        $response = $this->call('POST', '/api/auth/login', $credentials);
        $this->assertEquals(200, $response->status());

        $content = json_decode($response->getContent());
        $this->header['HTTP_X-Auth-Token'] = $content->token;
        $this->header['HTTP_ID'] = $content->user_id;
    }

    /**
     * Log out of the current user.
     *
     * @return void
     */
    protected function logout()
    {
        $response = $this->json('POST', '/api/auth/logout', [], $this->header);
        $this->assertResponseOk();

        $this->header['HTTP_X-Auth-Token'] = NULL;
        $this->header['HTTP_ID'] = NULL;
    }
}
