<?php

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [PanelController::class, 'categories'])->name('admin.categories.index');
Route::get('/products', [PanelController::class, 'products'])->name('admin.products.index');
Route::get('/products/{product}/units', [PanelController::class, 'product_units'])->name('admin.products.units');
Route::get('/products/download', [ExportController::class , 'exportProducts'])->name('admin.products.export');
