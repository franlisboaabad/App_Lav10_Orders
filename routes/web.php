<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DeviceTypeController;
use App\Http\Controllers\Admin\DeviceModelController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceOrderController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para la empresa
    Route::get('/company', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/company/edit/{company?}', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/company/{company?}', [CompanyController::class, 'update'])->name('companies.update');

    // Rutas para el CRUD de usuarios
    Route::resource('users', UserController::class);

    // Rutas para la Fase 2
    Route::resource('brands', BrandController::class);
    Route::resource('device-types', DeviceTypeController::class);
    Route::resource('device-models', DeviceModelController::class);
    Route::resource('customers', CustomerController::class);

    // Rutas para el CRUD de categorías
    Route::resource('categories', CategoryController::class);

    // Rutas para el CRUD de proveedores y productos
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);

    // Rutas para las órdenes de servicio
    Route::resource('service-orders', ServiceOrderController::class);
});

require __DIR__.'/auth.php';
