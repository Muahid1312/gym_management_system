<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::resource('plans', \App\Http\Controllers\PlanController::class)->except(['show']);
Route::resource('members', \App\Http\Controllers\MemberController::class)->except(['show']);
Route::resource('payments', \App\Http\Controllers\PaymentController::class)->only(['index', 'create', 'store']);

Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
Route::get('members/{member}/qr', [\App\Http\Controllers\AttendanceController::class, 'generateQr'])->name('members.qr');

Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export');

Route::post('members/{member}/generate-workout', [\App\Http\Controllers\AIController::class, 'generateWorkoutPlan'])->name('ai.workout');
Route::post('members/{member}/generate-diet', [\App\Http\Controllers\AIController::class, 'generateDietPlan'])->name('ai.diet');
