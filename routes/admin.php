<?php

use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [PanelController::class, 'categories'])->name('admin.categories.index');
Route::get('/products', [PanelController::class, 'products'])->name('admin.products.index');
