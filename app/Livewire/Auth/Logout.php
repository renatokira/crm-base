<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function render(): string
    {
        return <<<BLADE
                <div>
                    <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                        wire:click="logout" />
                </div>
            BLADE;

    }

    public function logout()
    {

        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'));
    }
}
