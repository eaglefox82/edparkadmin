<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name("home");

//Resource Controllers
Route::resource('member', 'App\Http\Controllers\MemberController');
Route::resource('uniforminspection', 'App\Http\Controllers\UniforminspectionController');
Route::resource('roll', 'App\Http\Controllers\RollController');

//Get Requests for Datatables
Route::get('members', [MemberController::class, 'getmembers'])->name('member.getmembers');



//Deployment - Use this to run migrations on the server
Route::get('/deployment', function () {
    Artisan::call('migrate');
    return 'Migrations ran successfully';
});
