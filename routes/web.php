<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\CoreBusinessController;
use App\Http\Controllers\ClassificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('offer')->group(function () {
    Route::get('{offer}/print', [OfferController::class, 'print'])->name('offer.print');
    Route::get('{offer}/view', [OfferController::class, 'view'])->name('offer.view');
    Route::get('{offer}/detail', [OfferController::class, 'detail'])->name('offer.detail');
    Route::put('{offer}/decision', [OfferController::class, 'decision'])->name('offer.decision');
    Route::post('{offer}/company', [OfferController::class, 'company'])->name('offer.company');
    Route::get('official', [OfferController::class, 'official'])->name('offer.official');
    Route::get('schedule/{tender_id}', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('schedule/{tender_id}/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('schedule/{tender_id}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('schedule/{tender_id}/update', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::get('schedule/{tender_id}/print', [ScheduleController::class, 'print'])->name('schedule.print');
    Route::get('schedule/{tender_id}/show', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::get('schedule/{tender_id}/detail', [ScheduleController::class, 'detail'])->name('schedule.detail');
    Route::get('schedule/{tender_id}/view', [ScheduleController::class, 'view'])->name('schedule.view');
    Route::delete('schedule/{tender_id}/destroy', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
});

Route::prefix('procurements')->group(function () {
    Route::resource('evaluation', EvaluationController::class)->only(['index', 'show']);
    Route::put('evaluation/{procurement_id}/company', [EvaluationController::class, 'company'])->name('evaluation.company');
    Route::put('evaluation/{procurement_id}/vendor', [EvaluationController::class, 'vendor'])->name('evaluation.vendor');
});

Route::prefix('partner')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::get('document/{partner_id}', [DocumentController::class, 'index'])->name('document.index');
    Route::get('document/{partner_id}/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('document/store', [DocumentController::class, 'store'])->name('document.store');
    Route::delete('document/{file_id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::get('fetch/{business_id}', [PartnerController::class, 'getPartnersByBusiness'])->name('partner.fetch');
});

Route::middleware(['auth'])->group(function () {
    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::get('report-vendor', [ReportController::class, 'vendor'])->name('report.vendor');
    Route::get('report-blacklist', [ReportController::class, 'blacklist'])->name('report.blacklist');
    Route::get('review', [ReviewController::class, 'index'])->name('review.index');
    Route::get('review-vendor', [ReviewController::class, 'vendor'])->name('review.vendor');
    Route::get('review-company', [ReviewController::class, 'company'])->name('review.company');
});

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('officials', OfficialController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('procurements', ProcurementController::class);
    Route::resource('core-business', CoreBusinessController::class);
    Route::resource('classification', ClassificationController::class);
    Route::resource('partner', PartnerController::class);
    Route::resource('offer', OfferController::class);
});

Route::middleware('auth', 'verified')->group(function(){
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('logactivity', LogActivityController::class)->only(['index', 'show']);
});

Route::prefix('dashboard')->group(function () {
    Route::get('vendor-count', [DashboardController::class, 'getVendorCount'])->name('dashboard.vendor-count');
    Route::get('procurement-count', [DashboardController::class, 'getProcurementCount'])->name('dashboard.procurement-count');
    Route::get('table-data-vendor', [DashboardController::class, 'getDataTableVendor'])->name('dashboard.table-data-vendor');
    Route::get('table-data-procurement', [DashboardController::class, 'getDataTableProcurement'])->name('dashboard.table-data-procurement');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
