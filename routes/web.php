<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\Detalle_compraController;
use App\Http\Controllers\Admin\DetalleCompraController;
use App\Http\Controllers\Admin\MovimientoStockController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\VentaController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::prefix('admin')->group(function () {
    Route::resource('categoria', CategoriaController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.categoria');
});

Route::prefix('admin')->group(function () {
    Route::resource('proveedor', ProveedorController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.proveedor');
});

Route::prefix('admin')->group(function () {
    Route::resource('producto', ProductoController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.producto');
});

Route::prefix('admin')->group(function () {
    Route::resource('usuario', UsuarioController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.usuario');
});

Route::prefix('admin')->group(function () {
    Route::resource('cliente', ClienteController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.cliente');
});

Route::prefix('admin')->group(function () {
    Route::resource('compra', CompraController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.compra');
});

Route::prefix('admin')->group(function () {
    Route::resource('detallecompra', DetalleCompraController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.detallecompra');
});

Route::prefix('admin')->group(function () {
    Route::resource('movimiento_stock', MovimientoStockController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.movimiento_stock');
});

Route::prefix('admin')->group(function () {
    Route::resource('venta', VentaController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.venta');
});

