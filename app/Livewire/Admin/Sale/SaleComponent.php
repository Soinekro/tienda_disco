<?php

namespace App\Livewire\Admin\Sale;

use App\Models\Category;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Provider;
use App\Models\Sale;
use App\Models\TypePay;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use App\Traits\Livewire\SearchDocument;
use App\Traits\Livewire\SearchSunat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class SaleComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;
    use SearchDocument;

    public $modalFormVisible = false;

    public $categories = [];
    public $products = [];
    public $productUnits = [];
    public $details_products = [];
    public $sale_id;

    public $date = '';
    public $provider_id = '';
    public $user_id = '';
    public $total = 0;
    public $ruc = '';
    public $name_provider = '';
    public $code = '';
    public $unit;
    public $category_id = '';
    public $searchProduct = null;
    public $productPick = null;

    public $showDrop = false;
    public $unit_product;
    public $quantityProduct;
    public $priceProduct;
    public $totalProduct;

    public $showPaydSale = false;
    public $salePaid;
    public $details_sale = [];
    public $totalCarrito = 0;
    public $typePayments = [];
    public $typePayment_id;
    public $amount = 0;

    public function mount()
    {
        $this->categories = Category::select('id', 'name')->get();
        if (session()->has('ventas')) {
            $this->details_products = session()->get('ventas');
            $this->totalCarrito = 0;
            foreach ($this->details_products as $detail) {
                $this->totalCarrito -= $detail['total'];
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

    public function resetInputs()
    {
        $this->resetValidation();
        $this->reset(
            [
                'sale_id',
                'date',
                'provider_id',
                'user_id',
                'total',
                'ruc',
                'name_provider',
                'code', 'unit',
                'category_id',
                'searchProduct',
                'productPick',
                'showDrop',
                'unit_product',
                'quantityProduct',
                'priceProduct',
                'totalProduct'
            ]
        );

        $this->details_products = [];
    }
    public function create()
    {
        $this->resetInputs();
        $this->categories = DB::table('categories')->select('id', 'name')->get();
        $this->modalFormVisible = true;
    }

    public function updatedRuc()
    {
        //debe tener 11 y 8 digitos para ruc y dni respectivamente
        if (strlen($this->ruc) == 11) {
            $tDoc = 'ruc';
        }elseif(strlen($this->ruc) == 8){
            $tDoc = 'dni';
        }else{
            $this->alerterror(__('El número de documento debe tener 11 dígitos para RUC y 8 dígitos para DNI'));
            return;
        }

        $provider = DB::table('clients')
            ->where('document_number', $this->ruc)
            ->first();
        if ($provider) {
            $this->name_provider = $provider->name;
            $this->provider_id = $provider->id;
        } else {
            $response = $this->searchDocument($tDoc, $this->ruc);
            if ($response['success']) {
                $this->name_provider = $response['nombre'];
            } else {
                $this->name_provider = '';
            }
            $this->provider_id = Provider::where('ruc', $this->ruc)->first()->id ?? null;
        }
    }

    public function updatedSearchProduct()
    {
        $this->products = DB::table('products')
            ->where('products.name', 'like', '%' . $this->searchProduct . '%')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })
            ->where('products.stock', '>', 0)
            ->select('products.id', 'products.name', 'products.price_sale', 'products.stock', 'categories.name as categoryname')
            ->get();
    }

    public function addProductID(Product $product)
    {
        $this->products = [];
        $this->category_id = null;
        $this->productPick = $product;
        $this->searchProduct = $product->name;
        $this->productUnits = $product->productUnits;
        $this->unit_product = $product->productUnits[0]->id;
        $this->unit = $this->productPick->productUnits()->where('id', $this->unit_product)->first();
        $this->quantityProduct = 1;
        $this->priceProduct = $product->price_sale;
        $this->totalProduct = $product->price_sale;
    }

    public function updatedQuantityProduct()
    {
        if ($this->quantityProduct > 0 && $this->productPick != null) {
            $this->totalProduct = round((float)$this->priceProduct * (float)$this->quantityProduct, 2);
        }
    }

    public function updatedUnitProduct()
    {
        $this->validate([
            'productPick' => 'required',
            'unit_product' => 'required|numeric|min:1|exists:product_units,id',
        ],
        [
            'productPick.required' => __('El campo producto es obligatorio'),
            'unit_product.required' => __('El campo unidad es obligatorio'),
            'unit_product.numeric' => __('El campo unidad debe ser un número'),
            'unit_product.min' => __('El campo unidad debe ser mayor a 0'),
            'unit_product.exists' => __('El campo unidad no existe'),
        ]
    );
        if ($this->unit_product != null && $this->productPick != null) {
            $this->unit = $this->productPick->productUnits()->where('id', $this->unit_product)->first();
            $this->priceProduct = $this->productPick->price_sale * $this->unit->quantity;
            $this->totalProduct = round((float)$this->priceProduct * (float)$this->quantityProduct, 2);
        }
    }

    public function updatedPriceProduct()
    {
        $this->validate([
            'priceProduct' => 'required|numeric|min:0',
        ]);
        if ($this->priceProduct > 0 && $this->productPick != null) {
            $this->totalProduct = round((float)$this->priceProduct * (float)$this->quantityProduct, 2);
        }
    }

    public function addProductToShop()
    {
        $this->validate([
            'productPick' => 'required',
            'quantityProduct' => 'required|numeric|min:1',
            'priceProduct' => 'required|numeric|min:0',
            'totalProduct' => 'required|numeric|min:0',
        ],
        [
            'productPick.required' => __('El campo producto es obligatorio'),
            'quantityProduct.required' => __('El campo cantidad es obligatorio'),
            'quantityProduct.numeric' => __('El campo cantidad debe ser un número'),
            'quantityProduct.min' => __('El campo cantidad debe ser mayor a 0'),
            'priceProduct.required' => __('El campo precio es obligatorio'),
            'priceProduct.numeric' => __('El campo precio debe ser un número'),
            'priceProduct.min' => __('El campo precio debe ser mayor a 0'),
            'totalProduct.required' => __('El campo total es obligatorio'),
            'totalProduct.numeric' => __('El campo total debe ser un número'),
            'totalProduct.min' => __('El campo total debe ser mayor a 0'),
        ]
    );

        // verificar si existe en session
        $ventas = session()->put('ventas', []);
        $ventas = session()->get('ventas');
        if ($ventas) {
            if (isset($ventas[$this->productPick->id])) {
                $this->alerterror(__('El producto ') . ' ' . $this->productPick->name . ' ' . __(' ya esta registrado'));
                return;
            }
        }
        //guardar la compra en una session llamada ventas y luego asignar a la variable details_products
        $this->details_products[$this->productPick->id] = [
            'product_id' => $this->productPick->id,
            'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity),
            'product_unit_id' => $this->unit->id,
            'quantity' => $this->quantityProduct,
            'price_sale' => (float) $this->priceProduct,
            'total' => (float) $this->totalProduct,
        ];
        $ventas = session()->get('ventas');
        if ($ventas) {
            $ventas[$this->productPick->id] = [
                'product_id' => $this->productPick->id,
                'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity),
                'product_unit_id' => $this->unit->id,
                'quantity' => $this->quantityProduct,
                'price_sale' => (float) $this->priceProduct,
                'total' => (float) $this->totalProduct,
            ];
            session()->put('ventas', $ventas);
        } else {
            session()->put('ventas', $this->details_products);
        }

        if ($this->sale_id) {
            DB::beginTransaction();
            try {
                $sale = Sale::find($this->sale_id);
                $sale->total = $this->total;
                $sale->update();
                $sale->details()->create([
                    'product_id' => $this->productPick->id,
                    'quantity' => $this->quantityProduct,
                    'product_unit_id' => $this->unit->id,
                    'price_buy' => $this->productPick->price_buy,
                    'price_sale' => $this->priceProduct,
                    'total' => $this->totalProduct,
                ]);
                $sale->total = $sale->details()->sum('total');
                $sale->update();
                //agregar stock al producto
                $product = Product::find($this->productPick->id);
                $product->stock -= $this->quantityProduct * $this->unit->quantity;
                $product->price_sale = $this->priceProduct / $this->unit->quantity;
                $product->update();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
            }
        }

        $this->searchProduct = null;
        $this->productUnits = [];
        $this->quantityProduct = null;
        $this->priceProduct = null;
        $this->totalProduct = null;
    }

    public function deleteProduct($id)
    {

        DB::beginTransaction();
        try {
            if ($this->sale_id) {
                $sale = Sale::find($this->sale_id);
                $sale->total = $this->total;
                $detail_p = $sale->details()
                    ->where('product_id', $id)
                    ->first();
                $detail_p->product
                    ->update([
                        'stock' => $detail_p->product->stock + ($detail_p->quantity * $detail_p->productUnit->quantity),
                    ]);
                $sale->details()->where('product_id', $id)->delete();
                $sale->total = $sale->details()->sum('total');
                $sale->update();
                DB::commit();
            }
            unset($this->details_products[$id]);
            $ventas = session()->get('ventas');
            unset($ventas[$id]);
            session()->put('ventas', $ventas);
            $this->total = 0;
            foreach ($this->details_products as $key => $value) {
                $this->total -= $value['total'];
            }
            $this->alertSuccess(__('Eliminado correctamente'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alerterror(__($e->getMessage()));
            Log::error($e->getMessage());
            return;
        }
    }

    public function store()
    {
        $this->validate([
            'details_products' => 'required|array|min:1',
            'total' => 'required|numeric|min:0',
        ],
        [
            'details_products.required' => __('El campo productos es obligatorio'),
            'details_products.min' => __('El campo productos debe tener al menos un producto'),
            'total.required' => __('El campo total es obligatorio'),
            'total.numeric' => __('El campo total debe ser un número'),
            'total.min' => __('El campo total debe ser mayor a 0'),
        ]
    );
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'serie' => 'T001',
                'correlative' => (Sale::orderBy('id', 'desc')->first()->correlative ?? 1) + 1,
                'client_id' => $this->provider_id,
                'user_id' => auth()->user()->id,
                'total' => $this->total,
            ]);
            foreach ($this->details_products as $key => $value) {
                $quantity = ProductUnit::find($value['product_unit_id'])->quantity;
                $product = Product::find($value['product_id']);
                $sale->details()->create([
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'product_unit_id' => $value['product_unit_id'],
                    'price_buy' => $product->price_buy,
                    'price_sale' => $value['price_sale'],
                    'total' => $value['total'],
                ]);
                //agregar stock al producto
                $product = Product::find($value['product_id']);
                $product->stock -= $value['quantity'] * $quantity;
                $product->price_sale = $value['price_sale'] / $quantity;
                $product->update();
            }
            DB::commit();
            //destruir session ventas
            $sale->total = $sale->details()->sum('total');
            $sale->update();
            session()->forget('ventas');
            $this->details_products = [];
            $this->modalFormVisible = false;
            $this->alertSuccess(__('Guardado correctamente'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alerterror(__('Error'));
            Log::error($e->getMessage());
            return;
        }
    }

    public function delete(Sale $sale)
    {
        if ($sale) {
            //descontar stock
            DB::beginTransaction();
            try {
                foreach ($sale->details as $value) {
                    $product = Product::find($value->product_id);
                    $product->stock -= $value->quantity * $value->productUnit->quantity;
                    $product->update();
                }
                $sale->delete();
                DB::commit();
                $this->alertSuccess(__('Eliminado correctamente'));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error al eliminar la venta');
                $this->alerterror(__('Error'));
            }
        } else {
            $this->alerterror(__('Error'));
        }
    }

    public function edit(Sale $sale)
    {
        $this->resetInputs();
        $this->categories = DB::table('categories')->select('id', 'name')->get();
        $this->sale_id = $sale->id;
        $this->code = $sale->serie . '-' . $sale->correlative;
        $this->ruc = $sale->client->document_number ?? 'Sin documento';
        $this->name_provider = $sale->client->name ?? 'sin nombre';
        $this->provider_id = $sale->client_id;
        $this->user_id = $sale->user_id;
        $ventas = session()->get('ventas');
        foreach ($sale->details as $value) {
            $this->details_products[$value->product_id] = [
                'product_id' => $value->product_id,
                'name' => $value->product->name . ' ' . $value->productUnit->unit->name . ' x ' . round($value->productUnit->quantity),
                'unit' => $value->unit_id,
                'product_unit_id' => $value->product_unit_id,
                'quantity' => $value->quantity,
                'price_sale' => $value->price_sale,
                'total' => $value->total,
            ];
            if ($ventas) {
                $ventas[$value->product_id] = [
                    'product_id' => $value->product_id,
                    'name' => $value->product->name . ' ' . $value->productUnit->unit->name . ' x ' . round($value->productUnit->quantity),
                    'unit' => $value->unit_id,
                    'product_unit_id' => $value->product_unit_id,
                    'quantity' => $value->quantity,
                    'price_sale' => $value->price_sale,
                    'total' => $value->total,
                ];
                session()->put('ventas', $ventas);
            } else {
                session()->put('ventas', $this->details_products);
            }
        }
        $this->total = $sale->total;
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate([
            'total' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $sale = Sale::find($this->sale_id);
            $sale->client_id = $this->provider_id;
            $sale->user_id = auth()->user()->id;
            $sale->total = $sale->details()->sum('total');
            $sale->update();
            DB::commit();
            //destruir session ventas
            session()->forget('ventas');
            $this->details_products = [];
            $this->modalFormVisible = false;
            $this->alertSuccess(__('Actualizado correctamente'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->alerterror(__($e->getMessage()));
            return;
        }
    }

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
                $this->salePaid->status = Sale::COMPLETED;
            } else {
                $this->salePaid->status = Sale::PENDING;
            }
            $this->salePaid->update();
            DB::commit();
            $this->cancelPaydSale();
            $this->alertSuccess(__('Sale') . ' ' . ('paid successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
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
