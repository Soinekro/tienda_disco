<?php

namespace App\Livewire\Admin\Shopping;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Provider;
use App\Models\Shopping;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use App\Traits\Livewire\SearchDocument;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class ShopComponent extends Component
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
    public $shop_id;

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

    public function render()
    {
        $shoppings = Shopping::with('provider', 'user')
            ->orderBy('shoppings.' . $this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.admin.shopping.shop-component', compact('shoppings'));
    }

    public function resetInputs()
    {
        $this->resetValidation();
        $this->reset(
            [
                'shop_id',
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
        session()->forget('compras');
        $this->categories = DB::table('categories')->select('id', 'name')->get();
        $this->modalFormVisible = true;
    }

    public function updatedCode()
    {
        $this->validate([
            'code' => 'required|unique:shoppings,code,NULL,id,provider_id,' . $this->provider_id . '|max:50',
        ]);
    }
    public function updatedRuc()
    {
        $provider = DB::table('providers')
            ->where('ruc', $this->ruc)
            ->first();
        if ($provider) {
            $this->name_provider = $provider->name;
            $this->provider_id = $provider->id;
        } else {
            $response = $this->searchDocument('ruc', $this->ruc);
            if ($response['success']) {
                $this->name_provider = $response['nombre'];
            } else {
                $this->name_provider = '';
            }
            $this->provider_id = Provider::where('ruc', $this->ruc)->first()->id;
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
        $this->priceProduct = $product->price_buy;
        $this->totalProduct = $product->price_buy;
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
        ]);
        if ($this->unit_product != null && $this->productPick != null) {
            $this->unit = $this->productPick->productUnits()->where('id', $this->unit_product)->first();
            $this->priceProduct = $this->productPick->price_buy * $this->unit->quantity;
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
        // dd($this->productPick, $this->quantityProduct, $this->priceProduct, $this->totalProduct);
        $this->validate([
            'productPick' => 'required',
            'quantityProduct' => 'required|numeric|min:1',
            'priceProduct' => 'required|numeric|min:0',
            'totalProduct' => 'required|numeric|min:0',
        ]);

        // verificar si existe en session
        $compras = session()->get('compras');
        if ($compras) {
            if (isset($compras[$this->productPick->id])) {
                $this->alerterror(__('Product') . ' ' . $this->productPick->name . ' ' . __('already exists'));
                return;
            }
        }
        //guardar la compra en una session llamada compras y luego asignar a la variable details_products
        $this->details_products[$this->productPick->id] = [
            'product_id' => $this->productPick->id,
            'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity),
            'product_unit_id' => $this->unit->id,
            'quantity' => $this->quantityProduct,
            'price_buy' => (float) $this->priceProduct,
            'total' => (float) $this->totalProduct,
        ];
        // dd($this->details_products);
        $compras = session()->get('compras');
        if ($compras) {
            $compras[$this->productPick->id] = [
                'product_id' => $this->productPick->id,
                'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity),
                'product_unit_id' => $this->unit->id,
                'quantity' => $this->quantityProduct,
                'price_buy' => (float) $this->priceProduct,
                'total' => (float) $this->totalProduct,
            ];
            session()->put('compras', $compras);
        } else {
            session()->put('compras', $this->details_products);
        }

        if ($this->shop_id) {
            DB::beginTransaction();
            try {
                $shopping = Shopping::find($this->shop_id);
                $shopping->total = $this->total;
                $shopping->update();
                $shopping->details()->create([
                    'product_id' => $this->productPick->id,
                    'quantity' => $this->quantityProduct,
                    'product_unit_id' => $this->unit->id,
                    'price_buy' => $this->priceProduct,
                    'total' => $this->totalProduct,
                ]);
                $shopping->total = $shopping->details()->sum('total');
                $shopping->update();
                //agregar stock al producto
                $product = Product::find($this->productPick->id);
                $product->stock += $this->quantityProduct * $this->unit->quantity;
                $product->price_buy = $this->priceProduct / $this->unit->quantity;
                $product->update();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->alerterror(__($e->getMessage()));
                return;
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
            if ($this->shop_id) {
                $shopping = Shopping::find($this->shop_id);
                $shopping->total = $this->total;
                $detail_p = $shopping->details()
                    ->where('product_id', $id)
                    ->first();
                $detail_p->product
                    ->update([
                        'stock' => $detail_p->product->stock - ($detail_p->quantity * $detail_p->productUnit->quantity),
                    ]);
                $shopping->details()->where('product_id', $id)->delete();
                $shopping->total = $shopping->details()->sum('total');
                $shopping->update();
                DB::commit();
            }
            unset($this->details_products[$id]);
            $compras = session()->get('compras');
            unset($compras[$id]);
            session()->put('compras', $compras);
            $this->total = 0;
            foreach ($this->details_products as $key => $value) {
                $this->total += $value['total'];
            }
            $this->alertSuccess(__('Deleted Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alerterror(__($e->getMessage()));
            return;
        }
    }

    public function store()
    {
        $this->validate([
            'details_products' => 'required|array|min:1',
            'code' => 'required|unique:shoppings,code,NULL,id,provider_id,' . $this->provider_id . '|max:50',
            'date' => 'required|date',
            'provider_id' => 'required|numeric|min:1|exists:providers,id',
            'total' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $shopping = Shopping::create([
                'code' => $this->code,
                'date' => $this->date,
                'provider_id' => $this->provider_id,
                'user_id' => auth()->user()->id,
                'total' => $this->total,
            ]);
            foreach ($this->details_products as $key => $value) {
                $quantity = ProductUnit::find($value['product_unit_id'])->quantity;
                $shopping->details()->create([
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'product_unit_id' => $value['product_unit_id'],
                    'price_buy' => $value['price_buy'],
                    'total' => $value['total'],
                ]);
                //agregar stock al producto
                $product = Product::find($value['product_id']);
                $product->stock += $value['quantity'] * $quantity;
                $product->price_buy = $value['price_buy'] / $quantity;
                $product->update();
            }
            DB::commit();
            //destruir session compras
            $shopping->total = $shopping->details()->sum('total');
            $shopping->update();
            session()->forget('compras');
            $this->details_products = [];
            $this->modalFormVisible = false;
            $this->alertSuccess(__('Saved Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alerterror(__('Error'));
            return;
        }
    }

    public function delete(Shopping $shopping)
    {
        if ($shopping) {
            //descontar stock
            DB::beginTransaction();
            try {
                foreach ($shopping->details as $value) {
                    $product = Product::find($value->product_id);
                    $product->stock -= $value->quantity * $value->productUnit->quantity;
                    $product->update();
                }
                $shopping->delete();
                DB::commit();
                $this->alertSuccess(__('Deleted Successfully'));
            } catch (\Exception $e) {
                DB::rollBack();
                $this->alerterror(__('Error'));
            }
        } else {
            $this->alerterror(__('Error'));
        }
    }

    public function edit(Shopping $shopping)
    {
        $this->resetInputs();
        $this->categories = DB::table('categories')->select('id', 'name')->get();
        $this->shop_id = $shopping->id;
        $this->code = $shopping->code;
        $this->ruc = $shopping->provider->ruc;
        $this->name_provider = $shopping->provider->name;
        $this->date = $shopping->date;
        $this->provider_id = $shopping->provider_id;
        $this->user_id = $shopping->user_id;
        $compras = session()->get('compras');
        foreach ($shopping->details as $value) {
            $this->details_products[$value->product_id] = [
                'product_id' => $value->product_id,
                'name' => $value->product->name . ' ' . $value->productUnit->unit->name . ' x ' . round($value->productUnit->quantity),
                'unit' => $value->unit_id,
                'product_unit_id' => $value->product_unit_id,
                'quantity' => $value->quantity,
                'price_buy' => $value->price_buy,
                'total' => $value->total,
            ];
            if ($compras) {
                $compras[$value->product_id] = [
                    'product_id' => $value->product_id,
                    'name' => $value->product->name . ' ' . $value->productUnit->unit->name . ' x ' . round($value->productUnit->quantity),
                    'unit' => $value->unit_id,
                    'product_unit_id' => $value->product_unit_id,
                    'quantity' => $value->quantity,
                    'price_buy' => $value->price_buy,
                    'total' => $value->total,
                ];
                session()->put('compras', $compras);
            } else {
                session()->put('compras', $this->details_products);
            }
        }
        $this->total = $shopping->total;
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate([
            'code' => 'required|unique:shoppings,code,' . $this->shop_id . ',id,provider_id,' . $this->provider_id . '|max:50',
            'date' => 'required|date',
            'provider_id' => 'required|numeric|min:1|exists:providers,id',
            'total' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {
            $shopping = Shopping::find($this->shop_id);
            $shopping->code = $this->code;
            $shopping->date = $this->date;
            $shopping->provider_id = $this->provider_id;
            $shopping->user_id = auth()->user()->id;
            $shopping->total = $shopping->details()->sum('total');
            $shopping->update();
            DB::commit();
            //destruir session compras
            session()->forget('compras');
            $this->details_products = [];
            $this->modalFormVisible = false;
            $this->alertSuccess(__('Updated Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->alerterror(__($e->getMessage()));
            return;
        }
    }
}
