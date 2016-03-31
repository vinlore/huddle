<?php

use Illuminate\Database\Seeder;

use App\Models\Conference;
use App\Models\Vehicle;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // CONFERENCE 2 - VEHICLE 1
        // ---------------------------------------------------------------------

        $conference = Conference::find(2);

        $vehicle = [
            'name'            => 'Car 1',
            'passenger_count' => 0,
            'capacity'        => '4',
        ];
        $vehicle = Vehicle::create($vehicle);
        $vehicle->conferences()->attach($conference, ['type' => 'arrival']);

        // ---------------------------------------------------------------------
        // CONFERENCE 2 - VEHICLE 2
        // ---------------------------------------------------------------------

        $vehicle = [
            'name'            => 'Car 2',
            'passenger_count' => 0,
            'capacity'        => '4',
        ];
        $vehicle = Vehicle::create($vehicle);
        $vehicle->conferences()->attach($conference, ['type' => 'departure']);
    }
}
