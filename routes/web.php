<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DefinitionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\NegotiationController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\CoreBusinessController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\RecapitulationController;

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
    Route::post('{offer}/change', [OfferController::class, 'change'])->name('offer.change');
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
    Route::get('{tender_id}/negotiation', [NegotiationController::class, 'index'])->name('negotiation.index');
    Route::get('{tender_id}/negotiation/create', [NegotiationController::class, 'create'])->name('negotiation.create');
    Route::post('{tender_id}/negotiation/store', [NegotiationController::class, 'store'])->name('negotiation.store');
    Route::delete('{tender_id}/negotiation/destroy', [NegotiationController::class, 'destroy'])->name('negotiation.destroy');
    Route::get('{tender_id}/negotiation/show', [NegotiationController::class, 'show'])->name('negotiation.show');
    Route::get('{tender_id}/negotiation/edit', [NegotiationController::class, 'edit'])->name('negotiation.edit');
    Route::put('{tender_id}/negotiation/update', [NegotiationController::class, 'update'])->name('negotiation.update');
});

Route::prefix('procurements')->group(function () {
    Route::resource('evaluation', EvaluationController::class)->only(['index', 'show']);
    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::get('administration/{procurement_id}/create', [AdministrationController::class, 'create'])->name('administration.create');
    Route::post('administration/store', [AdministrationController::class, 'store'])->name('administration.store');
    Route::get('administration/{procurement_id}', [AdministrationController::class, 'show'])->name('administration.show');
    Route::get('administration/{procurement_id}/edit', [AdministrationController::class, 'edit'])->name('administration.edit');
    Route::put('administration/{procurement_id}/update', [AdministrationController::class, 'update'])->name('administration.update');
    Route::get('administration/{procurement_id}/change', [AdministrationController::class, 'change'])->name('administration.change');
    Route::put('administration/{procurement_id}/save', [AdministrationController::class, 'save'])->name('administration.save');
    Route::delete('administration/{file_id}/destroy', [AdministrationController::class, 'destroy'])->name('administration.destroy');
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
    Route::get('recap-process-nego', [RecapitulationController::class, 'getProcessNego'])->name('recap.process-nego');
    Route::get('recap-process-nego-data', [RecapitulationController::class, 'getProcessNegoData'])->name('recap.process-nego-data');
    Route::get('recap-process-nego-excel', [RecapitulationController::class, 'getProcessNegoExcel'])->name('recap.process-nego-excel');
    Route::get('recap-comparison-matrix', [RecapitulationController::class, 'getComparisonMatrix'])->name('recap.comparison-matrix');
    Route::get('recap-comparison-matrix-data', [RecapitulationController::class, 'getComparisonMatrixData'])->name('recap.comparison-matrix-data');
    Route::get('recap-comparison-matrix-excel', [RecapitulationController::class, 'getComparisonMatrixExcel'])->name('recap.comparison-matrix-excel');
    Route::get('recap-efficiency-cost', [RecapitulationController::class, 'getEfficiencyCost'])->name('recap.efficiency-cost');
    Route::get('recap-efficiency-cost-data', [RecapitulationController::class, 'getEfficiencyCostData'])->name('recap.efficiency-cost-data');
    Route::get('recap-efficiency-cost-excel', [RecapitulationController::class, 'getEfficiencyCostExcel'])->name('recap.efficiency-cost-excel');
    Route::get('recap-request-cancelled', [RecapitulationController::class, 'getRequestCancelled'])->name('recap.request-cancelled');
    Route::get('recap-request-cancelled-data', [RecapitulationController::class, 'getRequestCancelledData'])->name('recap.request-cancelled-data');
    Route::get('recap-request-cancelled-excel', [RecapitulationController::class, 'getRequestCancelledExcel'])->name('recap.request-cancelled-excel');
    Route::get('documentation-value', [DocumentationController::class, 'basedOnValue'])->name('documentation.value');
    Route::get('documentation-value-monthly-data', [DocumentationController::class, 'basedOnValueMonthlyData'])->name('documentation.value-monthly-data');
    Route::get('documentation-value-annual-data', [DocumentationController::class, 'basedOnValueAnnualData'])->name('documentation.value-annual-data');
    Route::get('documentation-value-monthly-excel', [DocumentationController::class, 'basedOnValueMonthlyExcel'])->name('documentation.value-monthly-excel');
    Route::get('documentation-value-annual-excel', [DocumentationController::class, 'basedOnValueAnnualExcel'])->name('documentation.value-annual-excel');
    Route::get('documentation-division', [DocumentationController::class, 'basedOnDivision'])->name('documentation.division');
    Route::get('documentation-division-monthly-data', [DocumentationController::class, 'basedOnDivisionMonthlyData'])->name('documentation.division-monthly-data');
    Route::get('documentation-division-monthly-excel', [DocumentationController::class, 'basedOnDivisionMonthlyExcel'])->name('documentation.division-monthly-excel');
    Route::get('documentation-division-annual-data', [DocumentationController::class, 'basedOnDivisionAnnualData'])->name('documentation.division-annual-data');
    Route::get('documentation-division-annual-excel', [DocumentationController::class, 'basedOnDivisionAnnualExcel'])->name('documentation.division-annual-excel');
    Route::get('documentation-approval', [DocumentationController::class, 'basedOnApproval'])->name('documentation.approval');
    Route::get('documentation-request', [DocumentationController::class, 'basedOnRequest'])->name('documentation.request');
    Route::get('documentation-compare', [DocumentationController::class, 'basedOnCompare'])->name('documentation.compare');
    Route::get('monitoring-selected', [MonitoringController::class, 'tenderVendorSelected'])->name('monitoring.selected');
    Route::get('monitoring-process', [MonitoringController::class, 'monitoringProcess'])->name('monitoring.process');
    Route::get('chart', [ChartController::class, 'index'])->name('chart.index');
    Route::get('chart/procurements-data', [ChartController::class, 'procurementsData'])->name('chart.procurementsData');
    Route::get('chart/bar-chart', [ChartController::class, 'barChart'])->name('chart.barChart');
    Route::get('diagram', [DiagramController::class, 'index'])->name('diagram.index');
    Route::get('diagram/procurements-data', [DiagramController::class, 'procurementsData'])->name('diagram.procurementsData');
    Route::get('diagram/pie-diagram', [DiagramController::class, 'pieDiagram'])->name('diagram.pieDiagram');

});

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('definitions', DefinitionController::class);
    Route::resource('officials', OfficialController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('procurements', ProcurementController::class);
    Route::resource('core-business', CoreBusinessController::class);
    Route::resource('classification', ClassificationController::class);
    Route::resource('partner', PartnerController::class);
    Route::resource('offer', OfferController::class);
});

Route::middleware(['auth', 'verified'])->group(function(){
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
