<?php

use App\Http\Controllers\AAL\NasApiController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Import Authentication Routes
require __DIR__.'/auth.php';

//Protect all routes with authentication using this group
Route::middleware(['auth:sanctum'])->group(static function(){
    Route::get('/', [SiteController::class, 'home'])->name('home');
    Route::get('aal/nas_sync', [NasApiController::class, 'syncNasData'])->name('aal.nas.sync');
    Route::get('migrate', function () {
        Artisan::call('migrate');

        return "Database Migration Success";
    });
    Route::get('addRoles', [SiteController::class, 'addRoles']);
    Route::get('updateAccounts', [SiteController::class, 'updateAccounts']);

    //Import Event Routes
    require __DIR__.'/events/events.php';
});


