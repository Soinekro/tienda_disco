<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $this->units = DB::table('units')
            ->whereNotIn('id', function ($query) {
                $query->select('unit_id')
                    ->from('product_units')
                    ->where('product_id', '=', $this->product->id);
            })
            ->select('id', 'name')
            ->get();
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
        $this->validate(
            [
                'unit_id' => 'required|exists:units,id|unique:product_units,unit_id,NULL,id,product_id,' . $this->product->id . ',quantity,' . $this->quantity,
                'quantity' => 'required|numeric|min:1',
            ],
            [
                'unit_id.required' => __('La unidad es requerida!'),
                'unit_id.exists' => __('La unidad no existe!'),
                'unit_id.unique' => __('La unidad ya ha sido asignada a este producto!'),
                'quantity.required' => __('La cantidad es requerida!'),
                'quantity.numeric' => __('La cantidad debe ser un número!'),
                'quantity.min' => __('La cantidad debe ser mayor a 0!'),
            ]
        );
        try {
            $this->product->productUnits()->create([
                'unit_id' => $this->unit_id,
                'quantity' => $this->quantity,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            $this->alertError(__('Error al crear una unidad'));
            return;
        }
        $this->alertSuccess(__('Unidad creada con éxito!'));
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
            ],
            [
                'unit_id.required' => __('La unidad es requerida!'),
                'unit_id.exists' => __('La unidad no existe!'),
                'unit_id.unique' => __('La unidad ya ha sido asignada a este producto!'),
                'quantity.required' => __('La cantidad es requerida!'),
                'quantity.numeric' => __('La cantidad debe ser un número!'),
                'quantity.min' => __('La cantidad debe ser mayor a 0!'),
            ]
        );
        if ($this->unit_id == 'NIU') {
            $this->alertError(__('La unidad NIU no puede ser actualizada!'));
            return;
        }
        try {
            $this->product->productUnits()->where('id', $this->id)->update([
                'unit_id' => $this->unit_id,
                'quantity' => $this->quantity,
            ]);
            $this->alertSuccess(__('Unidad actualizada con éxito!'));
            $this->resetInputFields();
            $this->open = false;
        } catch (\Throwable $th) {
            $this->alertError(__('Error actualizando la unidad!'));
            return;
        }
    }
    public function destroy(ProductUnit $unit)
    {
        // $this->authorize('admin.units.destroy');
        if ($unit->unit_id == 'NIU') {
            $this->alertError(__('La unidad NIU no puede ser eliminada!'));
            return;
        }
        $unit->delete();
        $this->alertSuccess(__('Unidad eliminada con exito!'));
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
        if ($this->unit_id != null) {
            $this->quantity = round(Unit::find($this->unit_id)->quantity);
        }
    }
}
