<?php

use Illuminate\Database\Seeder;

use App\Models\Conference;
use App\Models\ConferenceVehicle;

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
        // CONFERENCE 2
        // ---------------------------------------------------------------------

        $conference = Conference::find(2);

        $vehicle = [
            'name'            => 'Airport Taxi',
            'passenger_count' => 0,
            'capacity'        => 4,
            'type'            => 'arrival',
        ];
        $vehicle = new ConferenceVehicle($vehicle);
        $vehicle->conference()->associate($conference);
        $vehicle->save();

        $vehicle = [
            'name'            => 'Airport Taxi',
            'passenger_count' => 0,
            'capacity'        => 4,
            'type'            => 'departure',
        ];
        $vehicle = new ConferenceVehicle($vehicle);
        $vehicle->conference()->associate($conference);
        $vehicle->save();
    }
}
