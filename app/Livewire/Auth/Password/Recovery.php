<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Recovery extends Component
{
    public ?string $message = null;

    #[Rule(['email', 'required'])]
    public ?string $email = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.password.recovery');
    }

    public function startPasswordRecovery(): void
    {
        $this->validate();

        $user = User::query()->where('email', $this->email)->first();

        $user?->notify(new PasswordRecoveryNotification());

        $this->message = 'We will send you an email with a link to reset your password.';
    }
}
