<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard route is now handled by DashboardController
});

use App\Http\Controllers\MinuteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinalMinuteController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/minutes', [MinuteController::class, 'index'])->name('minutes.index');
Route::get('/minutes/create', [MinuteController::class, 'create'])->name('minutes.create');
Route::post('/minutes', [MinuteController::class, 'store'])->name('minutes.store');
Route::get('/minutes/{actNumber}/edit', [MinuteController::class, 'edit'])->name('minutes.edit');
Route::put('/minutes/{actNumber}', [MinuteController::class, 'update'])->name('minutes.update');
Route::delete('/minutes/{actNumber}', [MinuteController::class, 'destroy'])->name('minutes.destroy');
Route::get('/minutes/{actNumber}/pdf', [MinuteController::class, 'pdf'])->name('minutes.pdf');

// FINAL MINUTES - Acta Reporte
Route::resource('final-minutes', FinalMinuteController::class);
Route::get('/final-minutes/{finalMinute}/download/{attachmentIndex}', [FinalMinuteController::class, 'downloadAttachment'])->name('final-minutes.download');
Route::get('/final-minutes/{finalMinute}/download-zip', [FinalMinuteController::class, 'downloadZip'])->name('final-minutes.download-zip');

//COMITE - Rutas separadas por modo
use App\Http\Controllers\GeneralCommitteeController;
use App\Http\Controllers\IndividualCommitteeController;

// Redirección temporal desde rutas antiguas hacia las nuevas
Route::get('/committee', function() { return redirect()->route('committee.individual.index'); });
Route::get('/committee/create', function() { return redirect()->route('committee.individual.create'); });

// Nuevas rutas separadas por modo (crear e indexar)
Route::prefix('committee')->group(function () {
    // Individual
    Route::get('/individual', [IndividualCommitteeController::class, 'index'])->name('committee.individual.index');
    Route::get('/individual/create', [IndividualCommitteeController::class, 'create'])->name('committee.individual.create');
    Route::post('/individual', [IndividualCommitteeController::class, 'store'])->name('committee.individual.store');
    Route::get('/individual/{individualCommittee}', [IndividualCommitteeController::class, 'show'])->name('committee.individual.show');
    Route::get('/individual/{individualCommittee}/edit', [IndividualCommitteeController::class, 'edit'])->name('committee.individual.edit');
    Route::put('/individual/{individualCommittee}', [IndividualCommitteeController::class, 'update'])->name('committee.individual.update');
    Route::delete('/individual/{individualCommittee}', [IndividualCommitteeController::class, 'destroy'])->name('committee.individual.destroy');
    Route::get('/individual/{individualCommittee}/pdf', [IndividualCommitteeController::class, 'pdf'])->name('committee.individual.pdf');

    // General
    Route::get('/general', [GeneralCommitteeController::class, 'index'])->name('committee.general.index');
    Route::get('/general/create', [GeneralCommitteeController::class, 'create'])->name('committee.general.create');
    Route::post('/general', [GeneralCommitteeController::class, 'store'])->name('committee.general.store');
    Route::get('/general/{generalCommittee}', [GeneralCommitteeController::class, 'show'])->name('committee.general.show');
    Route::get('/general/{generalCommittee}/edit', [GeneralCommitteeController::class, 'edit'])->name('committee.general.edit');
    Route::put('/general/{generalCommittee}', [GeneralCommitteeController::class, 'update'])->name('committee.general.update');
    Route::delete('/general/{generalCommittee}', [GeneralCommitteeController::class, 'destroy'])->name('committee.general.destroy');
    Route::get('/general/{generalCommittee}/pdf', [GeneralCommitteeController::class, 'pdf'])->name('committee.general.pdf');
});

// Eliminar comité (temporal - redirigir a individual)
Route::delete('/committee/{committee}', function() { return redirect()->route('committee.individual.index'); })->name('committee.destroy');

//ajax
Route::get('/ajax/minutes/search', [MinuteController::class, 'ajaxSearch'])->name('minutes.ajaxSearch');
