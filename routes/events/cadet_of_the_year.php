<?php

use App\Http\Controllers\Events\CadetOfTheYear\CadetOfTheYearController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::prefix('cadet_comp')->group(function () {
    //Dashboard
    Route::get('/{eventId}', [CadetOfTheYearController::class, 'index'])->name('cadet_comp.index');

    //Uniform Inspections
    Route::get('/{eventId}/uniforminspection/{memberId}/delete', [CadetOfTheYearController::class, 'deleteInspection'])->name('cadet_comp.uniforminspection.result.delete');
    Route::get('/{eventId}/admin/inspectionfields', [CadetOfTheYearController::class, 'fields_index'])->name('cadet_comp.uniforminspection.index');
    Route::get('/{eventId}/admin/inspectionfields/create', [CadetOfTheYearController::class, 'create'])->name('cadet_comp.uniforminspection.new');
    Route::post('/{eventId}/admin/inspectionfields', [CadetOfTheYearController::class, 'store'])->name('cadet_comp.uniforminspection.new.save');
    Route::get('/{eventId}/admin/inspectionfields/{fieldId}/edit', [CadetOfTheYearController::class, 'edit'])->name('cadet_comp.uniforminspection.edit');
    Route::post('/{eventId}/admin/inspectionfields/{fieldId}/edit', [CadetOfTheYearController::class, 'update'])->name('cadet_comp.uniforminspection.edit.save');
    Route::get('/{eventId}/admin/inspectionfields/{fieldId}', [CadetOfTheYearController::class, 'destroy'])->name('cadet_comp.uniforminspection.delete');

    Route::get('/upgrade/permissions', function () {
        Permission::create(['name' => 'Cadet Of The Year', 'guard_name' => 'web']);
        $adminRole = Role::query()->where('name', 'Admin')->first();
        if ($adminRole != null) {
            $adminRole->givePermissionTo('Cadet Of The Year');
        }
        return "Permissions Updated";
    });
});




