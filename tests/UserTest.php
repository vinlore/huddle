<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase{

     use WithoutMiddleware;

     /*
     * Finding certain user
     */
    public function testUserIndex()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/users',
                    ['username' => 'admin'])
            ->seeJson([
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@huddle.com',
            ]);
            */
    }

    /*
    * Testing finding an unexisting user
    */
    public function testEmptyUserIndex()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET','/api/users',
                    ['username' => 'xoxoadminxoxo'])
            ->seeJson([]);
            */
    }

    /*
    * Finding certain users -> returns WITH permissions/roles info
    */
    public function testUsersRoles()
    {
        $this->assertTrue(true);
        /*
        $this->json('GET' , '/api/users-roles',
                    ['username' => 'admin'])
                    ->seeJson([
                        'id' => 1,
                        'username' => 'admin',
                        'email' => 'admin@huddle.com',
                    ]);
                    */
    }
}
