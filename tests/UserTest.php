<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase{

     use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserIndex()
    {
        $this->json('GET','/api/users',
                    ['username' => 'admin'])
            ->seeJson([
                'id' => 1,
                'username' => 'admin',
                'email' => NULL,
            ]);
    }


    public function testEmptyUserIndex()
    {
        $this->json('GET','/api/users',
                    ['username' => 'empty'])
            ->seeJson([]);
    }

    public function testUsersRoles()
    {
        $this->json('GET' , '/api/users-roles',
                    ['username' => 'admin'])
                    ->seeJson([
                        'id' => 1,
                        'username' => 'admin',
                        'email' => NULL,
                    ]);
    }
}
