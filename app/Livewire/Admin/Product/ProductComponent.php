<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;

    public $product;
    public $product_id;
    public $name;
    public $category_id;
    public $price_buy;
    public $price_sale;
    public $stock;
    public $stock_min;
    public $description;
    public $categories = [];
    public $modalFormVisible = false;

    protected $listeners = [
        'delete',
    ];

    protected $rules = [
        'name' => 'required|min:3|max:255|unique:products,name,{$this->product_id},id',
        'category_id' => 'required|exists:categories,id|numeric',
        'price_buy' => 'required|numeric',
        'price_sale' => 'required|numeric',
        'stock' => 'required',
        'stock_min' => 'required',
    ];
    public function mount()
    {
        $this->categories = Category::select('id', 'name')->get();
    }
    public function render()
    {
        $products = Product::with('category')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.admin.product.product-component', compact('products'));
    }

    public function create()
    {
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
        $this->validate();
        Product::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Product') . ' ' . ('created successfully!'));
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
            ]
        );
    }
    public function edit($id)
    {
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
        $this->validate();
        Product::find($this->product_id)->update($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Product') . ' ' . ('updated successfully!'));
    }

    public function delete(Product $product)
    {
        $product->delete();
        $this->resetPage();
        $this->alertError(__('Product') . ' ' . ('deleted successfully!'));
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
}
