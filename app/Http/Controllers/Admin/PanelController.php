<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function categories()
    {
        return view('admin.categories.categoryview');
    }

    public function products()
    {
        return view('admin.products.productview');
    }
    public function product_units(Product $product)
    {
        return view('admin.products.product_units', compact('product'));
    }
}
