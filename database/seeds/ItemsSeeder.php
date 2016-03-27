<?php

use Illuminate\Database\Seeder;

use App\Models\Conference;
use App\Models\Item;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------------------------------------------
        // CONFERENCE 4 - ITEMS
        // ---------------------------------------------------------------------

        $conference = Conference::find(4);

        $item = [
            'name'     => 'Laptop',
            'quantity' => 1,
        ];
        $item = new Item($item);
        $item->conference()->associate($conference);
        $item->save();

        $item = [
            'name'     => 'Projector',
            'quantity' => 1,
        ];
        $item = new Item($item);
        $item->conference()->associate($conference);
        $item->save();
    }
}
