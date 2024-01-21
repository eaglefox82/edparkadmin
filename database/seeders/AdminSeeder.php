<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $user = User::create([
            'name' => 'Brendan Fox',
            'email' => 'brendan.fox@reynardthefox.info',
            'password' => bcrypt('n18094')
        ]);

        $user->assignRole('admin');

    }
}
