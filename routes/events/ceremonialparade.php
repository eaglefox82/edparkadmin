<?php

use App\Http\Controllers\Events\CeremonialParade\CeremonialParadeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['can:Ceremonial Parades']], function () {
    Route::get('ceremonialparade/{eventId}', [CeremonialParadeController::class, 'index'])->name('ceremonialparade.index');

    Route::get('ceremonialparade/{eventId}/squadron', [CeremonialParadeController::class, 'squadrons'])->name('ceremonialparade.squadron');
    Route::get('ceremonialparade/{eventId}/squadron/load', [CeremonialParadeController::class, 'squadrons_load'])->name('ceremonialparade.squadron.load');
    Route::get('ceremonialparade/{eventId}/squadron/{sqnId}/checkin', [CeremonialParadeController::class, 'squadron_checkin'])->name('ceremonialparade.squadron.checkin');
    Route::post('ceremonialparade/{eventId}/squadron/{sqnId}/checkin', [CeremonialParadeController::class, 'process_squadron_checkin'])->name('ceremonialparade.squadron.checkin');

    Route::get('ceremonialparade/{eventId}/wing', [CeremonialParadeController::class, 'wings'])->name('ceremonialparade.wing');
    Route::get('ceremonialparade/{eventId}/wing/load', [CeremonialParadeController::class, 'wings_load'])->name('ceremonialparade.wing.load');
    Route::get('ceremonialparade/{eventId}/wing/{wingId}/checkin', [CeremonialParadeController::class, 'wing_checkin'])->name('ceremonialparade.wing.checkin');
    Route::post('ceremonialparade/{eventId}/wing/{wingId}/checkin', [CeremonialParadeController::class, 'process_wing_checkin'])->name('ceremonialparade.wing.checkin');
});
