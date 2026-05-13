<?php

use Illuminate\Support\Facades\Route;

Route::get('locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/example', function () {
    return view('example');
})->name('example');

Route::get('/loading-demo', function () {
    return view('loading-demo');
})->name('loading.demo');

Route::resource('plans', \App\Http\Controllers\PlanController::class)->except(['show']);
Route::resource('members', \App\Http\Controllers\MemberController::class);
Route::get('members-minimal', function () {
    $search = request('search');
    $filter = request('filter', 'all');

    $query = \App\Models\Member::with(['plan', 'payments']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    switch ($filter) {
        case 'active':
            $query->where('expiry_date', '>', now());
            break;
        case 'expired':
            $query->where('expiry_date', '<=', now());
            break;
        case 'expiring_soon':
            $query->where('expiry_date', '>', now())
                  ->where('expiry_date', '<=', now()->addDays(3));
            break;
        case 'in_debt':
            $query->whereHas('payments', function ($q) {
                $q->where('status', 'pending');
            });
            break;
    }

    $members = $query->paginate(10);

    return view('members.index-minimal', compact('members', 'search', 'filter'));
})->name('members.index-minimal');
Route::resource('payments', \App\Http\Controllers\PaymentController::class)->only(['index', 'create', 'store']);
Route::resource('receipts', \App\Http\Controllers\ReceiptController::class)->only(['index', 'show']);
Route::resource('partners', \App\Http\Controllers\PartnerController::class);
Route::resource('lockers', \App\Http\Controllers\LockerController::class)->except(['show']);
Route::post('lockers/assign', [\App\Http\Controllers\LockerController::class, 'assign'])->name('lockers.assign');
Route::post('lockers/{locker}/release', [\App\Http\Controllers\LockerController::class, 'release'])->name('lockers.release');

Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);

// Receipt routes
Route::get('receipts/{receipt}/download', [\App\Http\Controllers\ReceiptController::class, 'download'])->name('receipts.download');
Route::get('receipts/{receipt}/view', [\App\Http\Controllers\ReceiptController::class, 'view'])->name('receipts.view');
Route::get('receipts/{receipt}/print', [\App\Http\Controllers\ReceiptController::class, 'print'])->name('receipts.print');
Route::get('payments/{paymentId}/receipt/download', [\App\Http\Controllers\ReceiptController::class, 'downloadByPayment'])->name('receipts.downloadByPayment');

// Partner routes
Route::post('partners/{partner}/mark-commissions-paid', [\App\Http\Controllers\PartnerController::class, 'markCommissionsAsPaid'])->name('partners.markCommissionsPaid');
Route::get('partners/{partner}/earnings-report', [\App\Http\Controllers\PartnerController::class, 'earningsReport'])->name('partners.earningsReport');

Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance/check-in', [\App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
Route::get('members/{member}/qr', [\App\Http\Controllers\AttendanceController::class, 'generateQr'])->name('members.qr');

Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export');

Route::post('members/{member}/generate-workout', [\App\Http\Controllers\AIController::class, 'generateWorkoutPlan'])->name('ai.workout');
Route::post('members/{member}/generate-diet', [\App\Http\Controllers\AIController::class, 'generateDietPlan'])->name('ai.diet');
Route::get('members/{member}/generate-plans', [\App\Http\Controllers\AIController::class, 'showGeneratePlanForm'])->name('ai.generate');
Route::get('members/{member}/plans', [\App\Http\Controllers\AIController::class, 'showPlans'])->name('ai.show-plans');
Route::get('members/{member}/plans/download-pdf', [\App\Http\Controllers\AIController::class, 'downloadPdf'])->name('ai.download-pdf');
Route::get('members/{member}/plans/download-pdf-professional', [\App\Http\Controllers\AIController::class, 'downloadPdfProfessional'])->name('ai.download-pdf-professional');
Route::get('members/{member}/plans/print', [\App\Http\Controllers\AIController::class, 'printPlans'])->name('ai.print-plans');
Route::get('members/{member}/plans/print-compact', [\App\Http\Controllers\AIController::class, 'printPlansCompact'])->name('ai.print-plans-compact');
Route::delete('workout-plans/{plan}', [\App\Http\Controllers\AIController::class, 'deleteWorkoutPlan'])->name('plans.workout.delete');
Route::delete('diet-plans/{plan}', [\App\Http\Controllers\AIController::class, 'deleteDietPlan'])->name('plans.diet.delete');

// Settings routes
Route::get('settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
Route::post('settings/gym-info', [\App\Http\Controllers\SettingsController::class, 'updateGymInfo'])->name('settings.updateGymInfo');
Route::delete('settings/gym-info', [\App\Http\Controllers\SettingsController::class, 'deleteGymInfo'])->name('settings.deleteGymInfo');
Route::delete('settings/logo', [\App\Http\Controllers\SettingsController::class, 'deleteLogo'])->name('settings.deleteLogo');
Route::post('settings/{section?}', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');

Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::post('backups/upload', [\App\Http\Controllers\BackupController::class, 'uploadRestore'])->name('backups.uploadRestore');
    Route::post('backups/restore', [\App\Http\Controllers\BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('backups/{filename}', [\App\Http\Controllers\BackupController::class, 'destroy'])->name('backups.destroy');
    Route::get('backups/download/{filename}', [\App\Http\Controllers\BackupController::class, 'download'])->name('backups.download');
});

// Temporarily allow backups index without admin for testing
Route::get('backups', [\App\Http\Controllers\BackupController::class, 'index'])->name('backups.index');
Route::post('backups', [\App\Http\Controllers\BackupController::class, 'store'])->name('backups.store');


// AI routes for minimal UI
Route::get('members/{member}/plans-minimal', function (\App\Models\Member $member) {
    $member->load([
        'workoutPlans' => fn($q) => $q->latest(),
        'dietPlans' => fn($q) => $q->latest(),
    ]);

    $workoutPlan = $member->workoutPlans->first();
    $dietPlan = $member->dietPlans->first();

    $formattedWorkout = null;
    $formattedDiet = null;

    if ($workoutPlan) {
        $formattedWorkout = app(\App\Services\PlanService::class)->formatWorkoutPlanForDisplay(
            $workoutPlan->plan_data ?? []
        );
    }

    if ($dietPlan) {
        $formattedDiet = app(\App\Services\PlanService::class)->formatDietPlanForDisplay(
            $dietPlan->plan_data ?? []
        );
        $dailyMacros = app(\App\Services\PlanService::class)->calculateDailyMacros($formattedDiet);
    }

    $bmi = null;
    $bmiCategory = null;
    if ($workoutPlan) {
        $bmi = app(\App\Services\PlanService::class)->calculateBmi($workoutPlan->weight, $workoutPlan->height);
        $bmiCategory = app(\App\Services\PlanService::class)->getBmiCategory($bmi);
    }

    return view('plans.show-minimal', [
        'member' => $member,
        'workoutPlan' => $workoutPlan,
        'dietPlan' => $dietPlan,
        'formattedWorkout' => $formattedWorkout,
        'formattedDiet' => $formattedDiet,
        'dailyMacros' => $dailyMacros ?? [],
        'bmi' => $bmi,
        'bmiCategory' => $bmiCategory,
    ]);
})->name('ai.show-plans-minimal');

