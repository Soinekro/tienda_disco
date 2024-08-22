<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Traits\Livewire\AlertsTrait;
use App\Traits\Livewire\PaginateTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{

    use WithPagination;
    use AlertsTrait;
    use PaginateTrait;

    public $open = false;
    public $user_id;
    public $user;
    public $name;
    public $username;
    public $email;
    public $phone;

    public $roles = [];
    public $role_id = null;
    public function render()
    {
        $this->authorize('admin.users.index');
        $users = User::orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
        return view('livewire.admin.users.user-component', compact('users'));
    }

    public function create()
    {
        $this->authorize('admin.users.create');
        $this->reset('name', 'username', 'email', 'phone', 'user_id', 'user');
        $this->roles = Role::select('id', 'name')
            ->get();
        $this->open = true;
    }

    public function save()
    {
        $this->user_id ? $this->authorize('admin.users.edit') : $this->authorize('admin.users.create');

        $this->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $this->user_id,
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'required|string|unique:users,phone,' . $this->user_id,
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => __('El campo nombre es requerido'),
            'username.required' => __('El campo usuario es requerido'),
            'username.unique' => __('El usuario ya existe'),
            'email.required' => __('El campo email es requerido'),
            'email.email' => __('El email no es válido'),
            'email.unique' => __('El email ya existe'),
            'phone.required' => __('El campo teléfono es requerido'),
            'phone.unique' => __('El teléfono ya existe'),
            'role_id.required' => __('El campo rol es requerido'),
            'role_id.exists' => __('El rol no existe'),
        ]);

        DB::beginTransaction();
        try {
            $user = User::updateOrCreate(
                ['id' => $this->user_id],
                [
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'password' => $this->user_id ? $this->user->password : Hash::make($this->username),
                ]
            );
            $user->roles()->sync($this->role_id);
            DB::commit();
            $this->alertSuccess(__('Usuario guardado correctamente'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->alertError(__('Error guardando el usuario'));
            return;
        }

        $this->open = false;
    }

    public function edit(User $user)
    {
        $this->authorize('admin.users.edit');
        $this->resetErrorBag();
        $this->open = true;
        $this->fill($this->user);
        $this->user_id = $this->user->id;
        $this->user = $user;
        $this->role_id = $user->roles->first()->id ?? null;
        $this->roles = Role::select('id', 'name')
            ->get();
    }

    public function delete(User $user)
    {
        $this->authorize('admin.users.delete');
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            $this->alertSuccess(__('Usuario eliminado correctamente'));
        } catch (Exception $e) {
            DB::rollBack();
            $this->alertError(__('Error eliminando el usuario'));
            Log::error($e->getMessage());
            return;
        }
    }
}
