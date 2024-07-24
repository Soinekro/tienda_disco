<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleComponent extends Component
{
    public function render()
    {
        $roles = Role::all();
        return view('livewire.admin.users.role-component', compact('roles'));
    }
}
