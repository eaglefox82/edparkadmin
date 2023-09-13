<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

//Add Member Resource Controller
Route::resource('member', 'App\Http\Controllers\MemberController');
//Add Uniform Inspection Resource Controller
Route::resource('uniforminspection', 'App\Http\Controllers\UniforminspectionController');
