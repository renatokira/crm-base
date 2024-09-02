<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\User;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    public function mount(User $user)
    {

        $this->authorize(CanEnum::BE_AN_ADMIN->value);

        $this->user = $user;
    }

    public function destroy()
    {

        $this->user->delete();
        $this->dispatch('user::deleted');
    }

    public function render()
    {
        return view('livewire.admin.users.delete');
    }
}
