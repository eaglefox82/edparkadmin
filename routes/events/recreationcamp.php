<?php

use App\Http\Controllers\Events\RecreationCamp\AccommodationController;
use App\Http\Controllers\Events\RecreationCamp\MembersController;
use App\Http\Controllers\Events\RecreationCamp\RecreationCampController;
use App\Http\Controllers\Events\RecreationCamp\TeamsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['can:Recreation Camps']], function () {
    Route::get('recreationcamp/{eventId}', [RecreationCampController::class, 'index'])->name('recreationcamp.index');
    Route::get('recreationcamp/{eventId}/accounting', [RecreationCampController::class, 'accounting'])->name('recreationcamp.accounting');
    Route::get('recreationcamp/{eventId}/report/overall', [RecreationCampController::class, 'campReport'])->name('recreationcamp.reports.overall');

    Route::get('recreationcamp/{eventId}/members', [MembersController::class, 'index'])->name('recreationcamp.members.index');
    Route::get('recreationcamp/{eventId}/members/{registrationId}', [MembersController::class, 'view'])->name('recreationcamp.members.view');
    Route::get('recreationcamp/{eventId}/members/{registrationId}/edit', [MembersController::class, 'edit'])->name('recreationcamp.members.edit');
    Route::post('recreationcamp/{eventId}/members/{registrationId}/edit', [MembersController::class, 'update'])->name('recreationcamp.members.edit');
    Route::get('recreationcamp/{eventId}/members/{registrationId}/checkin', [MembersController::class, 'campCheckIn'])->name('recreationcamp.members.checkin');
    Route::get('recreationcamp/{eventId}/medical', [MembersController::class, 'medicalMembers'])->name('recreationcamp.medical.index');
    Route::get('recreationcamp/{eventId}/dietary', [MembersController::class, 'dietaryMembers'])->name('recreationcamp.dietary.index');
    Route::get('recreationcamp/{eventId}/members/register/bymember', [MembersController::class, 'locateByMember'])->name('recreationcamp.members.register.member');
    Route::get('recreationcamp/{eventId}/members/register/bymember/{memberId}', [MembersController::class, 'registerByMember'])->name('recreationcamp.members.register.member.view');
    Route::post('recreationcamp/{eventId}/members/register/bymember', [MembersController::class, 'storeMemberRegistration'])->name('recreationcamp.members.register.member');
    Route::get('recreationcamp/{eventId}/members/register/byunit', [MembersController::class, 'locateByUnit'])->name('recreationcamp.members.register.unit');
    Route::get('recreationcamp/{eventId}/members/register/byunit/{unitId}', [MembersController::class, 'registerByUnit'])->name('recreationcamp.members.register.unit');
    Route::post('recreationcamp/{eventId}/members/register/byunit', [MembersController::class, 'storeByUnit'])->name('recreationcamp.members.register.unit');

    Route::get('recreationcamp/{eventId}/accommodation', [AccommodationController::class, 'index'])->name('recreationcamp.accommodation.index');
    Route::get('recreationcamp/{eventId}/accommodation/{roomId}', [AccommodationController::class, 'view'])->name('recreationcamp.accommodation.view');
    Route::get('recreationcamp/{eventId}/accommodation/print/all', [AccommodationController::class, 'printAllRooms'])->name('recreationcamp.accommodation.print.all');
    Route::get('recreationcamp/{eventId}/accommodation/{roomId}/print', [AccommodationController::class, 'printRoom'])->name('recreationcamp.accommodation.print.single');

    Route::get('recreationcamp/{eventId}/teams', [TeamsController::class, 'index'])->name('recreationcamp.teams.index');
    Route::get('recreationcamp/{eventId}/teams/print/all', [TeamsController::class, 'printAllTeams'])->name('recreationcamp.teams.print.all');
    Route::get('recreationcamp/{eventId}/teams/{teamId}/print', [TeamsController::class, 'printTeam'])->name('recreationcamp.teams.print.single');
});




