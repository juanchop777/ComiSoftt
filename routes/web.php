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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\MinutesController;

Route::get('/minutes', [MinutesController::class, 'index'])->name('minutes.index');
Route::get('/minutes/create', [MinutesController::class, 'create'])->name('minutes.create');
Route::post('/minutes', [MinutesController::class, 'store'])->name('minutes.store');
Route::get('/minutes/{actNumber}/edit', [MinutesController::class, 'edit'])->name('minutes.edit');
Route::put('/minutes/{actNumber}', [MinutesController::class, 'update'])->name('minutes.update');
Route::delete('/minutes/{actNumber}', [MinutesController::class, 'destroy'])->name('minutes.destroy');


//COMITE
use App\Http\Controllers\CommitteeController;

// Listar comités
Route::get('/committee', [CommitteeController::class, 'index'])->name('committee.index');

// Formulario de creación de comité
Route::get('/committee/create', [CommitteeController::class, 'create'])->name('committee.create');

// Guardar comité
Route::post('/committee', [CommitteeController::class, 'store'])->name('committee.store');

// Ver comité
Route::get('/committee/{committee}', [CommitteeController::class, 'show'])->name('committee.show');

// Editar comité
Route::get('/committee/{committee}/edit', [CommitteeController::class, 'edit'])->name('committee.edit');

// Actualizar comité
Route::put('/committee/{committee}', [CommitteeController::class, 'update'])->name('committee.update');

// Eliminar comité
Route::delete('/committee/{committee}', [CommitteeController::class, 'destroy'])->name('committee.destroy');

//ajax
Route::get('/ajax/minutes/search', [MinutesController::class, 'ajaxSearch'])->name('minutes.ajaxSearch');
