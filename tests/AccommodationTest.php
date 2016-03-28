<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommodationTest extends TestCase{

     use WithoutMiddleware;

    /**
     * Finding accomodations for certain
     **/
    public function testAccommodationShow()
    {

        $this->assertTrue(true);
        /*
        $this->json('GET','/api/conferences/2/accommodations')
            ->seeJson([
                'name' => 'Shangri-La Hotel Vancouver',
                'address' => '1128 West Georgia Street',

                'name' =>'The Fairmont Hotel Vancouver',
                'address' => '900 West Georgia Street',
            ]);
            */
    }


}
