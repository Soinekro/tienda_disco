<?php

namespace App\Livewire\Admin\Sale;

use App\Models\Category;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sale;
use App\Models\TypePay;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use App\Traits\Livewire\SearchSunat;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SaleComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;
    use SearchSunat;

    public $categories = [];
    public $category_id;
    public $products = [];
    public $productPicked;
    public $product_id;
    public $stockProduct = 0;
    public $quantityProduct = 1;
    public $priceProduct = 0;
    public $totalProduct = 0;
    public $totalCarrito = 0;

    public $document_number;
    public $client_id;
    public $name;
    public $address;


    public $details_products = [];

    public $searchProduct;

    public $showSale = false;
    public $sale = null;
    public $details_sale = [];

    public $showPaydSale = false;
    public $salePaid = null;
    public $typePayments = [];
    public $typePayment_id = null;
    public $amount = 0;

    public function mount()
    {
        $this->categories = Category::select('id', 'name')->get();
        //verifica si existe session de detalles de productos
        if (session()->has('details_products')) {
            $this->details_products = session()->get('details_products');
            $this->totalCarrito = 0;
            foreach ($this->details_products as $detail) {
                $this->totalCarrito += $detail['totalProduct'];
            }
        } else {
            $this->details_products = [];
        }
    }

    public function render()
    {
        $salesDB = Sale::orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
        return view('livewire.admin.sale.sale-component', compact('salesDB'));
    }

    public function updatedDocumentNumber()
    {
        $client = Client::where('document_number', $this->document_number)
            ->first();

        if ($client) {
            $this->client_id = $client->id;
            $this->name = $client->name;
            $this->address = $client->address;
        } else {
            //contar cuantos caracteres tiene el documento
            $n_char = strlen($this->document_number);
            $type = ($n_char == 8) ? 'dni' : 'ruc';

            $response = $this->searchDocument($type, $this->document_number);

            if ($response['success']) {
                if ($type == 'ruc') {
                    $this->name = $response['razon_social'];
                    $this->address = $response['address'];
                } else {
                    $this->name = $response['nombres'];
                }
            } else {
                $this->name = null;
                $this->address = null;
            }
        }
    }

    public function updatedCategoryId()
    {
        $this->products = Product::where('category_id', $this->category_id)
            ->when($this->searchProduct, function ($query) {
                return $query->where('name', 'like', '%' . $this->searchProduct . '%');
            })
            ->limit(3)
            ->get();
    }

    public function updatedSearchProduct()
    {
        if ($this->searchProduct != '') {
            $this->products = Product::where('name', 'like', '%' . $this->searchProduct . '%')
                ->when($this->category_id, function ($query) {
                    return $query->where('category_id', $this->category_id);
                })
                ->limit(3)
                ->get();
        }
    }

    public function addProductID(Product $product)
    {
        // dd($product);
        $this->productPicked = $product;
        $this->product_id = $product->id;
        $this->priceProduct = $product->price_sale;
        $this->stockProduct = $product->stock;
        $this->quantityProduct = 1;
        $this->totalProduct = round_two_decimals($this->priceProduct * $this->quantityProduct);
        $this->searchProduct = $product->name;
        $this->products = [];
    }

    public function updatedQuantityProduct()
    {
        if ($this->quantityProduct > $this->stockProduct) {
            $this->quantityProduct = $this->stockProduct;
        }
        if ($this->quantityProduct > 1) {
            // $this->quantityProduct = 1;
            $this->totalProduct = round_two_decimals($this->priceProduct * $this->quantityProduct);
        }
    }

    public function updatedTotalProduct()
    {
        if ($this->totalProduct > $this->stockProduct) {
            $this->totalProduct = $this->stockProduct;
        }
        $this->quantityProduct = round_two_decimals($this->totalProduct / $this->priceProduct);
    }

    public function updatedPriceProduct()
    {
        $this->totalProduct = round_two_decimals($this->priceProduct * $this->quantityProduct);
    }

    public function addProductToSale()
    {
        $this->validate([
            'product_id' => 'required',
            'quantityProduct' => 'required|numeric|min:1',
            'priceProduct' => 'required',
            'totalProduct' => 'required',
        ]);
        //verificar si existe el producto en el carrito
        $product = Product::find($this->product_id);
        if (array_key_exists($this->product_id, $this->details_products)) {
            //verificar si la cantidad del array y la cantidad del carrito es mayor al stock
            if ($this->details_products[$this->product_id]['quantity'] + $this->quantityProduct > $product->stock) {
                $this->alertError('No hay stock');
                return;
            }
            $this->details_products[$this->product_id]['quantity'] += $this->quantityProduct;
            $this->details_products[$this->product_id]['totalProduct'] += $this->totalProduct;
        } else {
            $this->details_products[$this->product_id] = [
                'product_id' => $this->product_id,
                'quantity' => $this->quantityProduct,
                'price' => $this->priceProduct,
                'totalProduct' => $this->totalProduct,
                'name' => $this->productPicked->name,
            ];
        }

        $product->stock -= $this->quantityProduct;
        $product->update();
        $this->totalCarrito += $this->totalProduct;
        //guarda en session
        session()->put('details_products', $this->details_products);
        //descuenta del stock

        $this->resetInputs();
    }

    public function deleteProduct($id)
    {
        foreach ($this->details_products as $detail) {
            //devuelve al stock
            $product = Product::find($detail['product_id']);
            $product->stock += $detail['quantity'];
            $product->update();
        }
        $this->totalCarrito = 0;
        unset($this->details_products[$id]);
        foreach ($this->details_products as $detail) {
            $this->totalCarrito += $detail['totalProduct'];
        }
        session()->put('details_products', $this->details_products);
    }

    public function resetInputs()
    {
        $this->reset(
            [
                'product_id',
                'quantityProduct',
                'priceProduct',
                'totalProduct',
                'stockProduct',
                'searchProduct',
                'products',
            ]
        );
    }

    public function decrementProduct($id)
    {
        $this->details_products[$id]['quantity']--;
        $this->details_products[$id]['totalProduct'] -= $this->details_products[$id]['price'];
        $this->totalCarrito -= $this->details_products[$id]['price'];
        //devuelve al stock
        $product = Product::find($id);
        $product->stock++;
        $product->update();
        if ($this->details_products[$id]['quantity'] == 0) {
            unset($this->details_products[$id]);
        }
        session()->put('details_products', $this->details_products);
    }

    public function incrementProduct($id)
    {
        $product = Product::find($id);
        //verifica si hay stock y que no se pasen del stock
        if ($product->stock > 0 && 1 <= $product->stock) {
            $this->details_products[$id]['quantity']++;
            $this->details_products[$id]['totalProduct'] += $this->details_products[$id]['price'];
            $this->totalCarrito += $this->details_products[$id]['price'];
            //descuenta del stock
            $product->stock--;
            $product->update();
            session()->put('details_products', $this->details_products);
        } else {
            $this->alertError('No hay stock');
        }
    }

    public function saveSale()
    {
        $this->validate([
            'details_products' => 'required|array|min:1',
        ]);
        $this->client_id = Client::where('document_number', $this->document_number)->first()->id ?? null;
        $details_products = session()->get('details_products');
        $total = 0;

        foreach ($details_products as $detail) {
            $total += $detail['totalProduct'];
        }

        $serie = Invoice::where('document_type', '80')->first();
        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'user_id' => auth()->user()->id,
                'client_id' => $this->client_id,
                'serie' => $serie->serie,
                'correlative' => $serie->number,
                'total' => $total,
            ]);

            foreach ($details_products as $detail) {
                $product = Product::find($detail['product_id']);
                $sale->details()->create([
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'price_buy' => $product->price_buy,
                    'price_sale' => $detail['price'],
                    'total' => $detail['totalProduct'],
                ]);
                $product->stock -= $detail['quantity'];
                $product->save();
            }
            $serie->number++;
            $serie->update();
            DB::commit();
            $this->resetInputs();
            session()->forget('details_products');
            $this->details_products = [];
            $this->alertSuccess(__('Sale') . ' ' . ('created successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->alertError('Error al guardar la venta');
            return;
        }
    }

    public function showDetails(Sale $sale)
    {
        $this->showSale = true;
        $this->sale = $sale;
        $this->details_sale = $sale->details;
        $this->totalCarrito = $sale->total;
    }

    public function cancelSaleDetails()
    {
        $this->showSale = false;
        $this->sale = null;
        $this->details_sale = [];
        $this->totalCarrito = 0;
    }

    public function deleteSale(Sale $sale)
    {
        DB::beginTransaction();
        try {
            foreach ($sale->details as $detail) {
                $product = Product::find($detail->product_id);
                $product->stock += $detail->quantity;
                $product->update();
            }
            $sale->payments()->delete();
            $sale->delete();
            DB::commit();
            $this->alertSuccess(__('Sale') . ' ' . ('deleted successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertError('Error al eliminar la venta');
            return;
        }
    }

    //pagos

    public function openPays(Sale $sale)
    {
        $this->showPaydSale = true;
        $this->salePaid = $sale;
        $this->details_sale = $sale->details;
        $this->totalCarrito = $sale->total;
        $this->typePayments = TypePay::select('id', 'name')->get();
        $this->amount = $sale->total - $sale->payments->sum('amount');
    }

    public function paydSale()
    {
        $paid = $this->salePaid->payments->sum('amount');
        $this->validate([
            'amount' => 'required|numeric|max:' . $this->salePaid->total - $paid,
        ]);
        DB::beginTransaction();
        try {
            $this->salePaid->payments()->create([
                'type_pay_id' => $this->typePayment_id,
                'amount' => $this->amount,
                'user_id' => auth()->user()->id,
                'type' => Sale::TYPE,
            ]);
            if ($this->amount == $this->salePaid->total) {
                $this->salePaid->status = Sale::PAID;
            } else {
                $this->salePaid->status = Sale::GENERATE;
            }
            $this->salePaid->update();
            DB::commit();
            $this->cancelPaydSale();
            $this->alertSuccess(__('Sale') . ' ' . ('paid successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alertError('Error al pagar la venta');
            return;
        }
    }

    public function cancelPaydSale()
    {
        $this->showPaydSale = false;
        $this->salePaid = null;
        $this->details_sale = [];
        $this->totalCarrito = 0;
        $this->amount = 0;
    }

}
