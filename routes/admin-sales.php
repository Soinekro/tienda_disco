<?php

use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PanelController::class, 'sales'])->name('admin.sales.index');
Route::get('/print/{sale}', [PanelController::class, 'printSale'])->name('sales.print');
