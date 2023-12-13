<?php

namespace App\Livewire\Admin\Shopping;

use App\Models\Shopping;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;

    public $modalFormVisible = false;

    public $categories = [];
    public $products = [];
    public $productUnits = [];
    public $details_products = [];
    public $shop_id;
    
    public function render()
    {
        $shoppings = Shopping::with('provider','user')
            ->orderBy('shoppings'.$this->sort, $this->direction)
            ->paginate($this->perPage);
        return view('livewire.admin.shopping.shop-component', compact('shoppings'));
    }

    public function create()
    {
        $this->categories = DB::table('categories')->select('id','name')->get();
        $this->modalFormVisible = true;

    }
}
