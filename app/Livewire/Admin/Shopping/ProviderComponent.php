<?php

namespace App\Livewire\Admin\Shopping;

use App\Models\Provider;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Livewire\Component;
use Livewire\WithPagination;

class ProviderComponent extends Component
{
    use WithPagination;
    use PaginateTrait;
    use AlertsTrait;
    public $modalFormVisible = false;
    public $provider_id;
    public $ruc;
    public $name;
    public $address;
    public $phone;
    public $email;

    public function render()
    {
        $providers = Provider::orderBy($this->sort, $this->direction)->paginate($this->perPage);
        return view('livewire.admin.shopping.provider-component', compact('providers'));
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
        $this->validate(
            [
                'ruc' => 'required|numeric|unique:providers,ruc,null,id',
                'name' => 'required|min:3|max:255|unique:providers,name,null,id',
                'address' => 'required|string',
                'phone' => 'required|numeric',
                'email' => 'nullable|string|email',

            ],
            [
                'ruc.required' => __('El campo RUC es obligatorio'),
                'ruc.numeric' => __('El campo RUC debe ser numérico'),
                'ruc.unique' => __('El campo RUC ya está en uso'),
                'name.required' => __('El campo nombre es obligatorio'),
                'name.min' => __('El campo nombre debe tener al menos 3 caracteres'),
                'name.max' => __('El campo nombre debe tener como máximo 255 caracteres'),
                'name.unique' => __('El campo nombre ya está en uso'),
                'address.required' => __('El campo dirección es obligatorio'),
                'phone.required' => __('El campo Teléfono es obligatorio'),
                'phone.numeric' => __('El campo Teléfono debe ser numérico'),
                'email.email' => __('El campo Email debe ser un correo válido'),
            ]
        );
        Provider::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Proveedor creado exitosamente!'));
    }

    public function resetInputs()
    {
        $this->reset(
            [
                'ruc',
                'name',
                'address',
                'email',
                'phone',
                'provider_id'
            ]
        );
    }
    public function edit($id)
    {
        $this->resetValidation();
        $this->resetInputs();
        $this->provider_id = $id;
        $this->loadData();
        $this->modalFormVisible = true;
    }

    public function loadData()
    {
        $data = Provider::find($this->provider_id);
        $this->fill($data->toArray());
    }

    public function update()
    {
        $this->validate(
            [
                'ruc' => 'required|numeric|unique:providers,ruc,'.$this->provider_id.',id',
                'name' => 'required|min:3|max:255',
                'address' => 'required|string',
                'phone' => 'required|numeric',
                'email' => 'nullable|string|email',
            ]
        );
        Provider::find($this->provider_id)->update($this->modelData());
        $this->modalFormVisible = false;
        $this->resetInputs();
        $this->alertSuccess(__('Proveedor actualizado exitosamente!'));
    }

    public function delete(Provider $product)
    {
        $product->delete();
        $this->resetPage();
        $this->alertError(__('Proveedor eliminado exitosamente!'));
    }

    public function modelData()
    {
        return [
            'ruc' => $this->ruc,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
        ];
    }
}
