<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function sales()
    {
        return view('dashboard');
    }

    public function printSale($sale)
    {
        $sale = Sale::with('details.product')->findOrFail($sale);
        //generar pdf
        $pdf = Pdf::loadView('admin.sales.print', compact('sale'));
        //mostrar para impresion

        return $pdf->stream($sale->serie.'-'.$sale->correlative.'.pdf');
        // return view('admin.sales.print', compact('sale'));
    }

}
