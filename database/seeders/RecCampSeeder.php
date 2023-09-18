<?php

namespace Database\Seeders;

use App\Models\RecreationCamp\RecreationCampEvent;
use App\Models\RecreationCamp\RecreationCampRoom;
use App\Models\RecreationCamp\RecreationCampTeam;
use Illuminate\Database\Seeder;

class RecCampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $camp = new RecreationCampEvent();
        $camp->name = '2023 Rec Camp';
        $camp->from_date = '2023-03-31 17:00:00';
        $camp->to_date = '2023-04-02 16:00:00';
        $camp->save();

        for ($roomNo = 1; $roomNo <= 18; $roomNo++)
        {
            $room = new RecreationCampRoom();
            $room->room_number = sprintf("%02d", $roomNo);
            $room->event_id = $camp->id;
            $room->capacity = 10;
            $room->save();
        }

        $room = new RecreationCampRoom();
        $room->room_number = "Up #1";
        $room->event_id = $camp->id;
        $room->capacity = 5;
        $room->save();

        $room = new RecreationCampRoom();
        $room->room_number = "Up #2";
        $room->event_id = $camp->id;
        $room->capacity = 5;
        $room->save();

        $teams = array('Yellow', 'Blue', 'Pink', 'Green', 'Purple', 'Leaders');
        foreach ($teams as $t)
        {
            $team = new RecreationCampTeam();
            $team->name = $t;
            $team->event_id = $camp->id;
            $team->save();
        }
    }
}
