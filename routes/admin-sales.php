<?php

use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/sales', [PanelController::class, 'sales'])->name('admin.sales.index');
Route::get('/print/{sale}', [PanelController::class, 'printSale'])->name('sales.print');
/*
Route::get('/products/{product}/units', [PanelController::class, 'product_units'])->name('admin.products.units'); */
