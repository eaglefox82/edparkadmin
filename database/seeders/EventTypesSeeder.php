<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventType::truncate();

        EventType::create([ 'name' => 'Training Camps', 'module_name' => 'TrainingCamp' ]);
        EventType::create([ 'name' => 'Swimming Carnivals', 'module_name' => 'SwimmingCarnival' ]);
        EventType::create([ 'name' => 'Recreation Camps', 'module_name' => 'RecreationCamp' ]);
        EventType::create([ 'name' => 'Athletics Carnivals', 'module_name' => 'AthleticsCarnival' ]);
    }
}
