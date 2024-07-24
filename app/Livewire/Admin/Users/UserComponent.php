<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UserComponent extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.admin.users.user-component', compact('users'));
    }
}
