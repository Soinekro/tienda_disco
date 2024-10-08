<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;
    use WithFileUploads;

    public $product;
    public $product_id;
    public $name;
    public $category_id;
    public $price_buy;
    public $price_sale;
    public $stock;
    public $stock_min;
    public $description;
    public $image;
    public $categories = [];
    public $modalFormVisible = false;

    protected $listeners = [
        'delete',
    ];

    public function mount()
    {
        $this->categories = Category::select('id', 'name')
            ->get();
    }
    public function render()
    {
        $this->authorize('admin.products.index');
        $products = Product::with('category', 'image')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.admin.product.product-component', compact('products'));
    }

    public function create()
    {
        $this->authorize('admin.products.create');
        $this->resetValidation();
        $this->resetInputs();
        $this->modalFormVisible = true;
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->resetInputs();
        $this->modalFormVisible = false;
    }

    public function store()
    {
        $this->authorize('admin.products.create');
        $this->validate(
            [
                'name' => 'required|min:3|unique:products,name,' . $this->product_id . ',id,category_id,' . $this->category_id,
                'category_id' => 'required|exists:categories,id',
                'price_buy' => 'required|numeric|min:0.1',
                'price_sale' => 'required|numeric|min:0.1|gt:price_buy',
                'stock' => 'required|numeric|min:0',
                'stock_min' => 'required|numeric|min:0',
            ],
            [
                'name.required' => __('El nombre es requerido'),
                'name.min' => __('El nombre debe tener al menos 3 caracteres'),
                'category_id.required' => __('La categoría es requerida'),
                'category_id.exists' => __('La categoría seleccionada no es válida'),
                'price_buy.required' => __('El precio de compra es requerido'),
                'price_buy.numeric' => __('El precio de compra debe ser un número'),
                'price_buy.min' => __('El precio de compra debe ser mayor a 0'),
                'price_sale.required' => __('El precio de venta es requerido'),
                'price_sale.numeric' => __('El precio de venta debe ser un número'),
                'price_sale.min' => __('El precio de venta debe ser mayor a 0'),
                'price_sale.gt' => __('El precio de venta debe ser mayor al precio de compra'),
                'stock.required' => __('El stock es requerido'),
                'stock.numeric' => __('El stock debe ser un número'),
                'stock.min' => __('El stock debe ser mayor a 0'),
                'stock_min.required' => __('El stock mínimo es requerido'),
                'stock_min.numeric' => __('El stock mínimo debe ser un número'),
                'stock_min.min' => __('El stock mínimo debe ser mayor a 0'),
            ]
        );
        DB::beginTransaction();
        try {
            $product = Product::create($this->modelData());
            $product->image()->create(
                [
                    'path' => $this->image->store('products')
                ]
            );
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->alertError(__('Error al crear el producto'));
            return;
        }
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Producto creado con éxito!'));
    }

    public function resetInputs()
    {
        $this->reset(
            [
                'name',
                'category_id',
                'price_buy',
                'price_sale',
                'stock',
                'stock_min',
                'description',
                'image',
            ]
        );
    }
    public function edit($id)
    {
        $this->authorize('admin.products.edit');
        $this->resetValidation();
        $this->resetInputs();
        $this->product_id = $id;
        $this->loadData();
        $this->modalFormVisible = true;
    }

    public function loadData()
    {
        $data = Product::find($this->product_id);
        $this->fill($data->toArray());
    }

    public function update()
    {
        $this->authorize('admin.products.edit');
        $this->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|min:3|unique:products,name,' . $this->product_id . ',id,category_id,' . $this->category_id,
                'price_buy' => 'required|numeric|min:0.1',
                'price_sale' => 'required|numeric|min:0.1|gt:price_buy',
                'stock' => 'required|numeric|min:0',
                'stock_min' => 'required|numeric|min:0',
            ],
            [
                'category_id.required' => __('La categoría es requerida'),
                'category_id.exists' => __('La categoría seleccionada no es válida'),
                'name.required' => __('El nombre es requerido'),
                'name.min' => __('El nombre debe tener al menos 3 caracteres'),
                'name.unique' => __('El nombre ya ha sido registrado'),
                'price_buy.required' => __('El precio de compra es requerido'),
                'price_buy.numeric' => __('El precio de compra debe ser un número'),
                'price_buy.min' => __('El precio de compra debe ser mayor a 0'),
                'price_sale.required' => __('El precio de venta es requerido'),
                'price_sale.numeric' => __('El precio de venta debe ser un número'),
                'price_sale.min' => __('El precio de venta debe ser mayor a 0'),
                'price_sale.gt' => __('El precio de venta debe ser mayor al precio de compra'),
                'stock.required' => __('El stock es requerido'),
                'stock.numeric' => __('El stock debe ser un número'),
                'stock.min' => __('El stock debe ser mayor a 0'),
                'stock_min.required' => __('El stock mínimo es requerido'),
                'stock_min.numeric' => __('El stock mínimo debe ser un número'),
                'stock_min.min' => __('El stock mínimo debe ser mayor a 0'),
            ]
        );
        try {
            Product::find($this->product_id)->update($this->modelData());
            $product = Product::find($this->product_id);
            Storage::delete($product->image->path);
            if ($product->image !== null) {
                $product->image()->update(
                    [
                        'path' => $this->image->store('products'),
                    ]
                );
            } else {
                $product->image()->create(
                    [
                        'path' => $this->image->store('products'),
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->alertError(__('Error al actualizar el producto'));
            return;
        }
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Producto actualizado con éxito!'));
    }

    public function delete(Product $product)
    {
        $this->authorize('admin.products.destroy');
        //verificar que no tenga productos asociados
        if ($product->salelists()->count() > 0) {
            $this->alertError(__('No se puede eliminar el producto, tiene ventas asociadas'));
            return;
        }
        if ($product->compras()->count() > 0) {
            $this->alertError(__('No se puede eliminar el producto, tiene compras asociadas'));
            return;
        }
        try {
            $product->units()->delete();
            $product->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->alertError(__('Error al eliminar el producto'));
            return;
        }
        $this->resetPage();
        $this->alertError(__('Producto eliminado con éxito!'));
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'price_buy' => $this->price_buy,
            'price_sale' => $this->price_sale,
            'stock' => $this->stock,
            'stock_min' => $this->stock_min,
        ];
    }

    public function toUnits($id)
    {
        return redirect()->route('admin.products.units', $id);
    }

    public function exportProducts()
    {
        return redirect()->route('admin.products.export');
    }
}
