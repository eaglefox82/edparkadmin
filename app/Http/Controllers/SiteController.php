<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SiteController extends Controller
{
    public function home(): Factory|View|Application
    {
        return view('home');
    }

    public function addRoles()
    {
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $staffRoles = Role::create(['name' => 'Training Camp Staff', 'guard_name' => 'web']);

        Permission::create(['name' => 'Training Camps', 'guard_name' => 'web']);
        Permission::create(['name' => 'Recreation Camps', 'guard_name' => 'web']);
        Permission::create(['name' => 'Ceremonial Parades', 'guard_name' => 'web']);

        $adminRole->givePermissionTo('Training Camps');
        $adminRole->givePermissionTo('Recreation Camps');
        $adminRole->givePermissionTo('Ceremonial Parades');

        $staffRoles->givePermissionTo('Training Camps');
    }

    public function updateAccounts()
    {
        $user = User::query()->where('email', 'tlarkin@falcongaming.com.au')->first();
        if ($user != null) {
            $user->syncRoles('Admin');
        }

        $user = User::query()->where('email', 'field.nsw@airleague.com.au')->first();
        if ($user != null) {
            $user->syncRoles('Admin');
        }

        $user = User::query()->where('email', 'gexc.nsw@airleague.com.au')->first();
        if ($user != null) {
            $user->password = bcrypt('Spitfire');
            $user->save();

            $user->syncRoles('Admin');
        }

        $user = new User();
        $user->first_name = 'Peter';
        $user->last_name = 'Gledhill';
        $user->email = 'operations.nsw@airleague.com.au';
        $user->password = bcrypt('Wirraway');
        $user->save();

        $user->syncRoles('Admin');

        $user = new User();
        $user->first_name = 'Pam';
        $user->last_name = 'Price';
        $user->email = 'training.asst.nsw@airleague.com.au';
        $user->password = bcrypt('DoyalsonOC');
        $user->save();

        $user->syncRoles('Training Camp Staff');
    }
}
