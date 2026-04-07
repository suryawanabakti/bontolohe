<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/konsultasi', function() {
        return view('konsultasi');
    })->name('konsultasi');

    Route::get('/edukasi', function() {
        return view('edukasi');
    })->name('edukasi');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Posyandu Routes
    Route::resource('patients', PatientController::class);
    Route::resource('examinations', ExaminationController::class);

    Route::resource('users', \App\Http\Controllers\UserController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/patients', [ReportController::class, 'patientReport'])->name('reports.patients');
    Route::get('/reports/examinations', [ReportController::class, 'examinationReport'])->name('reports.examinations');
    Route::get('/reports/monthly', [ReportController::class, 'posyanduMonthlyReport'])->name('reports.monthly');
    Route::get('/reports/stunting', [ReportController::class, 'stuntingReport'])->name('reports.stunting');
    Route::get('/reports/pregnant', [ReportController::class, 'pregnantReport'])->name('reports.pregnant');
    Route::post('/reports/target', [ReportController::class, 'storeTarget'])->name('reports.target.store');
});

require __DIR__ . '/auth.php';
