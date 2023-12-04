<?php

use App\Http\Controllers\Events\TrainingCamp\AccommodationController;
use App\Http\Controllers\Events\TrainingCamp\MealScheduleController;
use App\Http\Controllers\Events\TrainingCamp\MembersController;
use App\Http\Controllers\Events\TrainingCamp\FlightsController;
use App\Http\Controllers\Events\TrainingCamp\ScheduleController;
use App\Http\Controllers\Events\TrainingCamp\TrainingCampController;
use App\Http\Controllers\Events\TrainingCamp\UniformInspectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['can:Training Camps']], function () {
    //Dashboard
    Route::get('trainingcamp/{eventId}', [TrainingCampController::class, 'index'])->name('trainingcamp.index');

//Members
    Route::get('trainingcamp/{eventId}/members', [MembersController::class, 'index'])->name('trainingcamp.members.index');
    Route::get('trainingcamp/{eventId}/members/{registrationId}', [MembersController::class, 'view'])->name('trainingcamp.members.view');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/edit', [MembersController::class, 'edit'])->name('trainingcamp.members.edit');
    Route::post('trainingcamp/{eventId}/members/{registrationId}/edit', [MembersController::class, 'update'])->name('trainingcamp.members.edit');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/day_checkin', [MembersController::class, 'dayCheckIn'])->name('trainingcamp.members.day_checkin');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/checkout', [MembersController::class, 'campCheckOut'])->name('trainingcamp.members.checkout');
    Route::post('trainingcamp/{eventId}/members/checkin', [MembersController::class, 'campCheckIn'])->name('trainingcamp.members.checkin');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/checkin/final', [MembersController::class, 'checkinFinal'])->name('trainingcamp.members.checkin.final');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/checkin/print', [MembersController::class, 'printCheckIn'])->name('trainingcamp.members.checkin.print');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/checkin/print_page', [MembersController::class, 'printCheckInPage'])->name('trainingcamp.members.checkin.print_page');
    Route::get('trainingcamp/{eventId}/members/{registrationId}/print_slip', [MembersController::class, 'printMemberSlip'])->name('trainingcamp.members.print_slip');

    Route::get('trainingcamp/{eventId}/medical', [MembersController::class, 'medicalMembers'])->name('trainingcamp.medical.index');
    Route::get('trainingcamp/{eventId}/dietary', [MembersController::class, 'dietaryMembers'])->name('trainingcamp.dietary.index');

    Route::get('trainingcamp/{eventId}/members/register/bymember', [MembersController::class, 'locateByMember'])->name('trainingcamp.members.register.member');
    Route::get('trainingcamp/{eventId}/members/register/bymember/{memberId}', [MembersController::class, 'registerByMember'])->name('trainingcamp.members.register.member.view');
    Route::post('trainingcamp/{eventId}/members/register/bymember', [MembersController::class, 'storeMemberRegistration'])->name('trainingcamp.members.register.member');

//Member Sub-Lists
    Route::get('trainingcamp/{eventId}/band', [MembersController::class, 'bandTraining'])->name('trainingcamp.band.index');
    Route::get('trainingcamp/{eventId}/day_visitors', [MembersController::class, 'dayVisitors'])->name('trainingcamp.day_visitors.index');

//Accommodation
    Route::get('trainingcamp/{eventId}/accommodation', [AccommodationController::class, 'index'])->name('trainingcamp.accommodation.index');
    Route::get('trainingcamp/{eventId}/accommodation/{roomId}', [AccommodationController::class, 'view'])->name('trainingcamp.accommodation.view');
    Route::get('trainingcamp/{eventId}/accommodation/print/all', [AccommodationController::class, 'printAllRooms'])->name('trainingcamp.accommodation.print.all');
    Route::get('trainingcamp/{eventId}/accommodation/{roomId}/print', [AccommodationController::class, 'printRoom'])->name('trainingcamp.accommodation.print.single');

//Flights
    Route::get('trainingcamp/{eventId}/flights', [FlightsController::class, 'index'])->name('trainingcamp.flights.index');
    Route::get('trainingcamp/{eventId}/flights/print/all', [FlightsController::class, 'printAllFlights'])->name('trainingcamp.flights.print.all');
    Route::get('trainingcamp/{eventId}/flights/{flightId}/print', [FlightsController::class, 'printFlight'])->name('trainingcamp.flights.print.single');

//Uniform Inspections
    Route::get('trainingcamp/{eventId}/uniforminspection', [UniformInspectionController::class, 'inspectionResults'])->name('trainingcamp.uniforminspection.view');
    Route::get('trainingcamp/{eventId}/uniforminspection/{memberId}/delete', [UniformInspectionController::class, 'deleteInspection'])->name('trainingcamp.uniforminspection.result.delete');

//Schedule
    Route::get('trainingcamp/{eventId}/schedule', [ScheduleController::class, 'index'])->name('trainingcamp.schedule.index');

//Schedule - Meals
    Route::get('trainingcamp/{eventId}/schedule/meals/{mealId}', [MealScheduleController::class, 'viewMeal'])->name('trainingcamp.schedule.meals.view');
    Route::get('trainingcamp/{eventId}/schedule/meals', [MealScheduleController::class, 'createMealSchedule'])->name('trainingcamp.schedule.meals.create');
    Route::post('trainingcamp/{eventId}/schedule/meals', [MealScheduleController::class, 'storeMealSchedule'])->name('trainingcamp.schedule.meals.create.save');
    Route::post('trainingcamp/{eventId}/schedule/meals/{mealId}/delete', [MealScheduleController::class, 'deleteMealSchedule'])->name('trainingcamp.schedule.meals.delete');
    Route::get('trainingcamp/{eventId}/schedule/meals/{mealId}/{memberId}/present', [MealScheduleController::class, 'markMemberPresent'])->name('trainingcamp.schedule.meals.mark_present');

//Administration
    Route::get('trainingcamp/{eventId}/admin/accounting', [TrainingCampController::class, 'accounting'])->name('trainingcamp.accounting');
    Route::get('trainingcamp/{eventId}/admin/report/overall', [TrainingCampController::class, 'campReport'])->name('trainingcamp.reports.overall');

    Route::get('trainingcamp/{eventId}/admin/inspectionfields', [UniformInspectionController::class, 'index'])->name('trainingcamp.uniforminspection.index');
    Route::get('trainingcamp/{eventId}/admin/inspectionfields/create', [UniformInspectionController::class, 'create'])->name('trainingcamp.uniforminspection.new');
    Route::post('trainingcamp/{eventId}/admin/inspectionfields', [UniformInspectionController::class, 'store'])->name('trainingcamp.uniforminspection.new.save');
    Route::get('trainingcamp/{eventId}/admin/inspectionfields/{fieldId}/edit', [UniformInspectionController::class, 'edit'])->name('trainingcamp.uniforminspection.edit');
    Route::post('trainingcamp/{eventId}/admin/inspectionfields/{fieldId}/edit', [UniformInspectionController::class, 'update'])->name('trainingcamp.uniforminspection.edit.save');
    Route::get('trainingcamp/{eventId}/admin/inspectionfields/{fieldId}', [UniformInspectionController::class, 'destroy'])->name('trainingcamp.uniforminspection.delete');
});
