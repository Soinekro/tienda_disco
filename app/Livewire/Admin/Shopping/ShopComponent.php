<?php

namespace App\Livewire\Admin\Shopping;

use App\Models\Product;
use App\Models\Provider;
use App\Models\Shopping;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use App\Traits\Livewire\SearchDocument;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

use function Laravel\Prompts\select;

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

        //verificar si existe la session compras
        $compras = session()->get('compras');
        if ($compras) {
            $this->details_products = $compras;
            $this->total = 0;
            foreach ($compras as $key => $value) {
                $this->total += $value['total'];
            }
        }
        return view('livewire.admin.shopping.shop-component', compact('shoppings'));
    }

    public function create()
    {
        $this->categories = DB::table('categories')->select('id', 'name')->get();
        $this->modalFormVisible = true;
    }

    public function updatedRuc()
    {
        $provider = DB::table('providers')->where('ruc', $this->ruc)->first();
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
            $items = (float)$this->quantityProduct * (float)$this->unit->quantity;
            $this->totalProduct = (float)$this->priceProduct * (float)$items;
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
            $items = (float)$this->quantityProduct * (float)$this->unit->quantity;
            $this->totalProduct = (float)$this->priceProduct * (float)$items;
        }
    }

    public function updatedPriceProduct()
    {
        $this->validate([
            'priceProduct' => 'required|numeric|min:0',
        ]);
        if ($this->priceProduct > 0 && $this->productPick != null) {
            $items = (float)$this->quantityProduct * (float)$this->unit->quantity;
            $this->totalProduct = (float)$this->priceProduct * (float)$items;
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
        //guardar la compra en una session llamada compras y luego asignar a la variable details_products
        $this->details_products[$this->productPick->id] = [
            'product_id' => $this->productPick->id,
            'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity) ,
            'unit' => $this->unit_product,
            'quantity' => $this->quantityProduct,
            'price' => (float) $this->priceProduct,
            'total' => (float) $this->totalProduct,
        ];
        $compras = session()->get('compras');
        if ($compras) {
            $compras[$this->productPick->id] = [
                'product_id' => $this->productPick->id,
                'name' => $this->productPick->name . ' ' . $this->unit->unit->name . ' x ' . round($this->unit->quantity) ,
                'unit' => $this->unit_product,
                'quantity' => $this->quantityProduct,
                'price' => (float) $this->priceProduct,
                'total' => (float) $this->totalProduct,
            ];
            session()->put('compras', $compras);
        } else {
            session()->put('compras', $this->details_products);
        }
        $this->total += $this->totalProduct;

        $this->searchProduct = null;
        $this->productUnits = [];
        $this->quantityProduct = null;
        $this->priceProduct = null;
        $this->totalProduct = null;
    }

    public function deleteProduct($id)
    {
        unset($this->details_products[$id]);
        $compras = session()->get('compras');
        unset($compras[$id]);
        session()->put('compras', $compras);
        $this->total = 0;
        foreach ($this->details_products as $key => $value) {
            $this->total += $value['total'];
        }
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:shoppings,code,NULL,id,provider_id,' . $this->provider_id . '|max:50',
            'date' => 'required|date',
            'provider_id' => 'required|numeric|min:1|exists:providers,id',
            'total' => 'required|numeric|min:0',
        ]);
        // dd($this->details_products);
        $shopping = Shopping::create([
            'code' => $this->code,
            'date' => $this->date,
            'provider_id' => $this->provider_id,
            'user_id' => auth()->user()->id,
            'total' => $this->total,
        ]);
        foreach ($this->details_products as $key => $value) {
            $shopping->details()->create([
                'product_id' => $value['product_id'],
                'unit_id' => $value['unit'],
                'quantity' => $value['quantity'],
                'price_buy' => $value['price'],
                'total' => $value['total'],
            ]);
            //agregar stock al producto
            $product = Product::find($value['product_id']);
            $product->stock += $value['quantity'];
            $product->update();
        }

        $this->modalFormVisible = false;
        $this->alert('success', 'Compra registrada con éxito');
    }
}
