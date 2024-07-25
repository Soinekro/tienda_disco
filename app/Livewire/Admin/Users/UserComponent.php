<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Traits\Livewire\AlertsTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{

    use WithPagination;
    use AlertsTrait;

    public $open = false;
    public $user_id;
    public $user;
    public $name;
    public $username;
    public $email;
    public $phone;

    public function render()
    {
        $users = User::all();
        return view('livewire.admin.users.user-component', compact('users'));
    }

    public function create()
    {
        $this->reset('name', 'username', 'email', 'phone', 'user_id', 'user');
        $this->open = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $this->user_id,
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'required|string|unique:users,phone,' . $this->user_id,
        ]);

        DB::beginTransaction();
        try {
            User::updateOrCreate(
                ['id' => $this->user_id],
                [
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'password' => $this->user_id ? $this->user->password : Hash::make($this->username),
                ]
            );
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
        $this->open = true;
        $this->user = $user;
        $this->user_id = $this->user->id;
        $this->fill($this->user);
    }

    public function delete(User $user)
    {
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
