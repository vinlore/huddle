<?php

use Illuminate\Database\Seeder;

use App\Models\Accommodation;
use App\Models\Conference;
use App\Models\Room;

class AccommodationsAndRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // CONFERENCE 2 - ACCOMMODATION 1
        // ---------------------------------------------------------------------

        $conference = Conference::find(2);

        $accommodation = [
            'name'    => 'Shangri-La Hotel Vancouver',
            'address' => '1128 West Georgia Street',
            'city'    => 'Vancouver',
            'country' => 'Canada',
        ];
        $accommodation = Accommodation::create($accommodation);
        $accommodation->conferences()->attach($conference);

        $room = [
            'room_no'     => '100',
            'guest_count' => 0,
            'capacity'    => 2,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = [
            'room_no'     => '101',
            'guest_count' => 0,
            'capacity'    => 3,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = [
            'room_no'     => '102',
            'guest_count' => 0,
            'capacity'    => 4,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();

        // ---------------------------------------------------------------------
        // CONFERENCE 2 - ACCOMMODATION 2
        // ---------------------------------------------------------------------

        $accommodation = [
            'name'    => 'The Fairmont Hotel Vancouver',
            'address' => '900 West Georgia Street',
            'city'    => 'Vancouver',
            'country' => 'Canada',
        ];
        $accommodation = Accommodation::create($accommodation);
        $accommodation->conferences()->attach($conference);

        $room = [
            'room_no'     => '200',
            'guest_count' => 0,
            'capacity'    => 2,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = [
            'room_no'     => '201',
            'guest_count' => 0,
            'capacity'    => 3,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();

        $room = [
            'room_no'     => '202',
            'guest_count' => 0,
            'capacity'    => 4,
        ];
        $room = new Room($room);
        $room->accommodation()->associate($accommodation);
        $room->save();
    }
}
