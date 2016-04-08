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
        'password' => 'password',
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
     * Login with a set of user credentials.
     *
     * @return void
     */
    protected function login($credentials)
    {
        $this->json('POST', '/api/signin', $credentials);
        $this->assertResponseOk();
    }
}