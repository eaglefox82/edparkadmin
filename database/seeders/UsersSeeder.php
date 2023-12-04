<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();

        $user = new User();
        $user->first_name = 'Tim';
        $user->last_name = 'Larkin';
        $user->email = 'tlarkin@falcongaming.com.au';
        $user->password = bcrypt('goblin');
        $user->save();

        $user = new User();
        $user->first_name = 'Brendan';
        $user->last_name = 'Fox';
        $user->email = 'field.nsw@airleague.com.au';
        $user->password = bcrypt('Mustang');
        $user->save();

        $user = new User();
        $user->first_name = 'Jeff';
        $user->last_name = 'Remington';
        $user->email = 'gexc.nsw@airleague.com.au';
        $user->password = bcrypt('Spitfire');
        $user->save();

        $user = new User();
        $user->first_name = 'Caitlin';
        $user->last_name = 'Lindsay';
        $user->email = 'pa.nsw@airleague.com.au';
        $user->password = bcrypt('Wirraway');
        $user->save();
    }
}
