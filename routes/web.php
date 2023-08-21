<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\PermissionController;
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

Route::prefix('partner')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::get('document/{partner_id}', [DocumentController::class, 'index'])->name('document.index');
    Route::get('document/{partner_id}/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('document/store', [DocumentController::class, 'store'])->name('document.store');
    Route::delete('document/{file_id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::get('fetch/{business_id}', [PartnerController::class, 'getPartnersByBusiness'])->name('partner.fetch');
});

Route::get('/', function () {
    return view('auth/login');
});

Route::resource('officials', OfficialController::class);
Route::resource('divisions', DivisionController::class);
Route::resource('procurements', ProcurementController::class);
Route::resource('core-business', CoreBusinessController::class);
Route::resource('classification', ClassificationController::class);
Route::resource('partner', PartnerController::class);
Route::resource('offer', OfferController::class);


Route::middleware('auth', 'verified')->group(function(){
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
});

Route::get('/dashboard', function () {
    return view('layouts.template');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
