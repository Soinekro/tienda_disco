<?php

namespace App\Livewire\Admin\Users;

use App\Traits\Livewire\AlertsTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleComponent extends Component
{

    use WithPagination;
    use AlertsTrait;

    public $open = false;
    public $role_id;
    public $name;
    public $role;
    public $permissions = [];
    public $permissions_picked = [];

    public function mount()
    {
        $this->permissions = Permission::get();
    }

    public function render()
    {
        $this->authorize('admin.roles.index');
        $roles = Role::all();
        return view('livewire.admin.users.role-component', compact('roles'));
    }

    public function create()
    {
        $this->authorize('admin.roles.create');
        $this->reset('name', 'permissions_picked', 'role_id', 'role');
        $this->open = true;
    }

    public function store()
    {
        $this->authorize('admin.roles.create');
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role_id,
            'permissions_picked' => 'required|array|min:1',
        ]);
        DB::beginTransaction();
        try {
            $role_save = Role::create([
                'name' => $this->name,
                'guard_name' => 'web'
            ]);
            $role_save->permissions()->sync($this->permissions_picked);
            DB::commit();
            $this->alertSuccess(__('Rol creado con exito'));
        } catch (Exception $e) {
            DB::rollBack();
            $this->alertError(__('Error en la creacion de rol'));
            Log::error($e->getMessage());
        }
        $this->reset('name', 'permissions_picked', 'role_id', 'role');
        $this->open = false;
    }


    public function selectAll()
    {
        $this->permissions_picked = $this->permissions->pluck('id')->map(function ($id) {
            return (string) $id;
        });
    }

    public function unselectAll()
    {
        $this->permissions_picked = [];
    }

    public function edit($id)
    {
        $this->authorize('admin.roles.edit');
        $this->role = Role::find($id);
        $this->role_id = $id;
        $this->name = $this->role->name;
        $this->permissions_picked = $this->role->permissions->pluck('id')->map(function ($id) {
            return (string) $id;
        })->toArray();
        $this->open = true;
    }

    public function update()
    {
        $this->authorize('admin.roles.edit');
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role_id,
            'permissions_picked' => 'required|array|min:1',
        ]);
        DB::beginTransaction();
        try {
            $this->role->update([
                'name' => $this->name,
                'guard_name' => 'web'
            ]);
            $this->role->permissions()->sync($this->permissions_picked);
            DB::commit();
            $this->alertSuccess(__('Rol actualizado con exito'));
        } catch (Exception $e) {
            DB::rollBack();
            $this->alertError(__('Error en la actualizacion de rol'));
            Log::error($e->getMessage());
        }
        $this->reset('name', 'permissions_picked', 'role_id', 'role');
        $this->open = false;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            Role::find($id)->delete();
            $this->alertSuccess(__('Rol eliminado con exito'));
        } catch (Exception $e) {
            DB::rollBack();
            $this->alertError(__('Error en la eliminacion de rol'));
            Log::error($e->getMessage());
        }
    }
}
