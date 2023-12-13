<?php

namespace App\Livewire\Admin\Shopping;

use App\Models\Shopping;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;

    public $modalFormVisible = false;
    public function render()
    {
        $shoppings = Shopping::with('provider','user')
            ->orderBy('shoppings'.$this->sort, $this->direction)
            ->paginate($this->perPage);
        return view('livewire.admin.shopping.shop-component', compact('shoppings'));
    }
}
