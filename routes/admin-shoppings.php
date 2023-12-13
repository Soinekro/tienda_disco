<?php

use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/providers', [PanelController::class, 'providers'])->name('admin.providers.index');
Route::get('/shoppings', [PanelController::class, 'shoppings'])->name('admin.shoppings.index');
/* Route::get('/products/{product}/units', [PanelController::class, 'product_units'])->name('admin.products.units');
 */
