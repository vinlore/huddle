<?php

use Illuminate\Database\Seeder;

use App\Models\Conference;
use App\Models\Event;

class ConferencesAndEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // CONFERENCE 1
        // ---------------------------------------------------------------------

        $conference = [
            'name'        => 'India Conference',
            'description' => 'A conference in India.',
            'start_date'  => '2016-03-01',
            'end_date'    => '2016-03-31',
            'address'     => 'Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India',
            'city'        => 'New Delhi',
            'country'     => 'India',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];
        $conference = Conference::create($conference);

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-01',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => 'Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India',
            'city'         => 'New Delhi',
            'country'      => 'India',
            'capacity'     => 1000,
            'status'       => 'approved',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        // ---------------------------------------------------------------------
        // CONFERENCE 2
        // ---------------------------------------------------------------------

        $conference = [
            'name'        => 'Canada Conference',
            'description' => 'A conference in Canada.',
            'start_date'  => '2016-05-11',
            'end_date'    => '2016-05-20',
            'address'     => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'        => 'Vancouver',
            'country'     => 'Canada',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];
        $conference = Conference::create($conference);

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-11',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => '1055 Canada Pl, Vancouver, BC V6C 0C3, Canada',
            'city'         => 'Vancouver',
            'country'      => 'Canada',
            'capacity'     => 1000,
            'status'       => 'approved',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        // ---------------------------------------------------------------------
        // CONFERENCE 3
        // ---------------------------------------------------------------------

        $conference = [
            'name'        => 'France Conference',
            'description' => 'A conference in France.',
            'start_date'  => '2016-05-21',
            'end_date'    => '2016-05-30',
            'address'     => '17 Boulevard Saint-Jacques, Paris 75014, France',
            'city'        => 'Paris',
            'country'     => 'France',
            'capacity'    => 1000,
            'status'      => 'approved',
        ];
        $conference = Conference::create($conference);

        $event = [
            'name'         => 'Opening Ceremony',
            'description'  => 'Welcome!',
            'facilitator'  => 'TBD',
            'date'         => '2016-05-21',
            'start_time'   => '09:00:00',
            'end_time'     => '10:00:00',
            'address'      => '17 Boulevard Saint-Jacques, Paris 75014, France',
            'city'         => 'Paris',
            'country'      => 'France',
            'capacity'     => 1000,
            'status'       => 'approved',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        // ---------------------------------------------------------------------
        // CONFERENCE 4
        // ---------------------------------------------------------------------

        $conference = [
            'name'        => 'CPSC 319 Final Demos',
            'description' => 'Teams present their projects.',
            'start_date'  => '2016-03-31',
            'end_date'    => '2016-04-07',
            'address'     => 'Hugh Dempster Pavilion, 6245 Agronomy Road, Vancouver, BC V6T 1Z4',
            'city'        => 'Vancouver',
            'country'     => 'Canada',
            'capacity'    => 74,
            'status'      => 'pending',
        ];
        $conference = Conference::create($conference);

        $event = [
            'name'         => 'Project 2 Final Demos',
            'description'  => 'Teams 5 to 8 present their projects.',
            'facilitator'  => 'Dr Ahmed Awad',
            'date'         => '2016-03-31',
            'start_time'   => '12:30:00',
            'end_time'     => '14:00:00',
            'address'      => 'Hugh Dempster Pavilion, 6245 Agronomy Road, Vancouver, BC V6T 1Z4',
            'city'         => 'Vancouver',
            'country'      => 'Canada',
            'capacity'     => 74,
            'status'       => 'pending',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        $event = [
            'name'         => 'Project 3 Final Demos',
            'description'  => 'Teams 9 to 12 present their projects.',
            'facilitator'  => 'Dr Ahmed Awad',
            'date'         => '2016-04-05',
            'start_time'   => '12:30:00',
            'end_time'     => '14:00:00',
            'address'      => 'Hugh Dempster Pavilion, 6245 Agronomy Road, Vancouver, BC V6T 1Z4',
            'city'         => 'Vancouver',
            'country'      => 'Canada',
            'capacity'     => 74,
            'status'       => 'pending',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();

        $event = [
            'name'         => 'Project 1 Final Demos',
            'description'  => 'Teams 1 to 4 present their projects.',
            'facilitator'  => 'Dr Ahmed Awad',
            'date'         => '2016-04-07',
            'start_time'   => '12:30:00',
            'end_time'     => '14:00:00',
            'address'      => 'Hugh Dempster Pavilion, 6245 Agronomy Road, Vancouver, BC V6T 1Z4',
            'city'         => 'Vancouver',
            'country'      => 'Canada',
            'capacity'     => 74,
            'status'       => 'pending',
        ];
        $event = new Event($event);
        $event->conference()->associate($conference);
        $event->save();
    }
}
