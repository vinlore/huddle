<?php

use Illuminate\Database\Seeder;

use App\Models\Conference;
use App\Models\Event;

class ManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Conference::all() as $conference) {
            $conference->managers()->attach(1);
        }

        foreach (Event::all() as $event) {
            $event->managers()->attach(1);
        }
    }
}
