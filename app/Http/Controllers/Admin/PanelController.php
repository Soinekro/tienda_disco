<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
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

    public function providers()
    {
        return view('admin.shoppings.providers');
    }

    public function shoppings()
    {
        return view('admin.shoppings.index');
    }

    public function printSale($sale)
    {
        $sale = Sale::with('details.product')->findOrFail($sale);
        //generar pdf
        // $pdf = \PDF::loadView('admin.sales.print', compact('sale'));
        //descargar pdf

        // return $pdf->download('invoice.pdf');
        return view('admin.sales.print', compact('sale'));
    }

}
