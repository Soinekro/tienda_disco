<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UnitProductComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;

    public $open = false;
    public $product;
    public $units;
    public $id;
    public $unit_id;
    public $quantity = 1;

    public function mount(Product $product)
    {
        $this->product = Product::find($product->id);
        $this->units = DB::table('units')->select('id', 'name')->get();
    }
    public function render()
    {
        $product_units = DB::table('product_units')
            ->join('units', 'product_units.unit_id', '=', 'units.id')
            ->select('product_units.id', 'units.id as idUnit', 'product_units.quantity', 'units.name')
            ->where('product_units.product_id', '=', $this->product->id)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);

        return view('livewire.admin.product.unit-product-component', compact('product_units'));
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------
    public function create()
    {
        // $this->authorize('admin.units.create');
        $this->resetInputFields();
        $this->open = true;
    }

    public function store()
    {
        // $this->authorize('admin.units.create');
        $this->validate([
            'unit_id' => 'required|exists:units,id|unique:product_units,unit_id,NULL,id,product_id,' . $this->product->id . ',quantity,' . $this->quantity,
            'quantity' => 'required|numeric|min:1',
        ]);
        try {
            $this->product->productUnits()->create([
                'unit_id' => $this->unit_id,
                'quantity' => $this->quantity,
            ]);
        } catch (\Throwable $th) {
            dd($th);
            $this->alertError(__('Error creating unit!'));
            return;
        }
        $this->alertSuccess(__('Unit created successfully!'));
        $this->resetInputFields();
        $this->open = false;
    }

    public function edit(ProductUnit $unit)
    {
        $this->resetInputFields();
        // $this->authorize('admin.units.edit');
        $this->unit_id = $unit->unit_id;
        $this->quantity = $unit->quantity;
        $this->id = $unit->id;
        $this->action = 'update';
        $this->open = true;
    }

    public function update()
    {
        // $this->authorize('admin.units.edit');
        $this->validate(
            [
                'unit_id' => 'required|exists:units,id|unique:product_units,unit_id,' . $this->id . ',id,product_id,' . $this->product->id . ',quantity,' . $this->quantity,
                'quantity' => 'required|numeric|min:1',
            ]
        );
        if ($this->unit_id == 'NIU') {
            $this->alertError(__('NIU can not be Edited!'));
            return;
        }
        try {
            $this->product->productUnits()->where('id', $this->id)->update([
                'unit_id' => $this->unit_id,
                'quantity' => $this->quantity,
            ]);
        } catch (\Throwable $th) {
            $this->alertError(__('Error updating unit!'));
            return;
        }
        $this->alertSuccess(__('Unit updated successfully!'));
        $this->resetInputFields();
        $this->open = false;
    }
    public function destroy(ProductUnit $unit)
    {
        // $this->authorize('admin.units.destroy');
        if ($unit->id == 'NIU') {
            $this->alertError(__('NIU can not be deleted!'));
            return;
        }
        $unit->delete();
        $this->alertSuccess(__('Unit deleted successfully!'));
    }
    public function resetInputFields()
    {
        $this->unit_id = null;
        $this->quantity = 1;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetPage();
        $this->action = 'create';
    }

    public function updatedUnitId()
    {
        $this->quantity = round(Unit::find($this->unit_id)->quantity);
    }
}
