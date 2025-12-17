<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PVController;

Route::get('/', function () { return redirect()->route('pvs.index'); });
Route::get('/pvs', [PVController::class, 'index'])->name('pvs.index');
Route::get('/pvs/create', [PVController::class, 'create'])->name('pvs.create');
Route::post('/pvs', [PVController::class, 'store'])->name('pvs.store');
Route::get('/pvs/{pv}', [PVController::class, 'show'])->name('pvs.show');
Route::get('/pvs/import', [PVController::class, 'importForm'])->name('pvs.import.form');
Route::post('/pvs/import', [PVController::class, 'import'])->name('pvs.import');
Route::post('/pvs/{pv}/documents', [PVController::class, 'uploadDocument'])->name('pvs.documents.upload');
Route::post('/pvs/{pv}/copies', [PVController::class, 'uploadStudentCopy'])->name('pvs.copies.upload');
