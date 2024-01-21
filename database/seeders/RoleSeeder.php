<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $userRole = Role::create(['name' => 'OC']);
        $userRole = Role::create(['name' => 'Adjutant']);
        $userRole = Role::create(['name' => '2nd Officer']);
        $userRole = Role::create(['name' => 'Warrent Officer']);
        $userRole = Role::create(['name' => 'NCO']);
    }
    }
}
