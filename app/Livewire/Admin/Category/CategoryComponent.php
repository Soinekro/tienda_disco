<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use AlertsTrait;
    use PaginateTrait;
    use WithPagination;

    public $modalFormVisible = false;
    public $name;
    public $category_id;

    public function render()
    {
        $this->authorize('admin.categories.index');
        $categories = Category::with('products')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
        return view('livewire.admin.category.category-component', compact('categories'));
    }


    public function create()
    {
        $this->authorize('admin.categories.create');
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->action = 'create';
    }

    public function edit($id)
    {
        $this->authorize('admin.categories.edit');
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->action = 'update';
        $this->category_id = $id;
        $this->loadModel();
    }

    public function loadModel()
    {
        $data = Category::find($this->category_id);
        $this->name = $data->name;
    }

    public function store()
    {
        $this->authorize('admin.categories.create');
        $this->validate();
        Category::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    public function update()
    {
        $this->authorize('admin.categories.edit');
        $this->validate();
        Category::find($this->category_id)->update($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function delete($id)
    {
        $this->authorize('admin.categories.destroy');
        //verificar que no tenga productos asociados
        $category = Category::with('products')->find($id);
        if ($category->products->count() > 0) {
            $this->alertError('No se puede eliminar la categoría, tiene productos asociados');
            return;
        }
        Category::destroy($id);
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:categories,name,' . $this->category_id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
        ];
    }
}
