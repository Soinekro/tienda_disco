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
    public $role_id;

    public $roles = [];
    public $role_id = null;
    public function render()
    {
        $this->authorize('admin.users.index');
        $users = User::orderBy($this->sort, $this->direction)
            ->whereNotIn('id', [auth()->id(), 1])
            ->paginate($this->perPage);
        $roles = Role::whereNotIn('id', ['1'])->get();
        return view('livewire.admin.users.user-component', compact('users', 'roles'));
    }

    public function create()
    {
        $this->authorize('admin.users.create');
<<<<<<< HEAD
        $this->reset('name', 'username', 'email', 'phone', 'user_id', 'user', 'role_id');
=======
        $this->reset('name', 'username', 'email', 'phone', 'user_id', 'user');
        $this->roles = Role::select('id', 'name')
            ->get();
>>>>>>> 36e016ef238949828c9297c77b4a2c959b8a33e2
        $this->open = true;
    }

    public function save()
    {
        $this->user_id ? $this->authorize('admin.users.edit') : $this->authorize('admin.users.create');
        //si el id del usuario es el mismo que el usuario autenticado
        if ($this->user_id == auth()->id()) {
            $this->alertError(__('No puedes editar tu propio usuario'));
            return;
        }

        //un usuario no puede tener el rol de superadmin
        if ($this->role_id == 1) {
            $this->alertError(__('No puedes asignar el rol de superadmin'));
            return;
        }
        $this->validate([
            'name' => 'required|string',
            // 'username' => 'required|string|unique:users,username,' . $this->user_id,
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'required|string|unique:users,phone,' . $this->user_id,
<<<<<<< HEAD
            'role_id' => 'required|exists:roles,id|not_in:1|integer',
        ], [
            'name.required' => __('El nombre es requerido'),
            'username.required' => __('El nombre de usuario es requerido'),
            'username.unique' => __('El nombre de usuario ya está en uso'),
            'email.required' => __('El email es requerido'),
            'email.email' => __('El email no es válido'),
            'email.unique' => __('El email ya está en uso'),
            'phone.required' => __('El teléfono es requerido'),
            'phone.unique' => __('El teléfono ya está en uso'),
            'role_id.required' => __('El rol es requerido'),
            'role_id.exists' => __('El rol seleccionado no es válido'),
            'role_id.not_in' => __('No puedes asignar el rol de superadmin')
=======
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
>>>>>>> 36e016ef238949828c9297c77b4a2c959b8a33e2
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
<<<<<<< HEAD
            $user->roles()
                ->sync([$this->role_id]);
=======
            $user->roles()->sync($this->role_id);
>>>>>>> 36e016ef238949828c9297c77b4a2c959b8a33e2
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
<<<<<<< HEAD
        $this->user = $user;
        $this->user_id = $this->user->id;
        $this->role_id = $this->user->roles->first()->id ?? null;
=======
>>>>>>> 36e016ef238949828c9297c77b4a2c959b8a33e2
        $this->fill($this->user);
        $this->user_id = $this->user->id;
        $this->user = $user;
        $this->role_id = $user->roles->first()->id ?? null;
        $this->roles = Role::select('id', 'name')
            ->get();
    }

    public function delete(User $user)
    {
        $this->authorize('admin.users.destroy');
        DB::beginTransaction();
        try {
            $user->delete();
            $user->syncRoles([]);
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
