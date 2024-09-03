<?php

namespace App\Livewire\Admin\Users;

use App\Enum\CanEnum;
use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?User $user = null;

    public bool $modal = false;

    #[Rule(['required', 'confirmed'])]
    public string $confirm = 'DELETAR';

    public ?string $confirm_confirmation = null;

    public function mount()
    {
        $this->authorize(CanEnum::BE_AN_ADMIN->value);
    }

    public function destroy()
    {
        $this->validate();

        if ($this->user->is(auth()->user())) {

            $this->addError('confirm', "You can't delete yourself brow.");

            return;
        }

        $this->user->delete();
        $this->user->notify(new UserDeletedNotification());

        $this->dispatch('user::deleted');
        $this->reset('modal');

        $this->success('User deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.users.delete');
    }

    #[On('user::deletion')]
    public function openConfirmationFor(int $userId): void
    {
        $this->resetErrorBag('confirm');
        $this->reset('confirm_confirmation');

        $this->user  = User::select('id', 'name')->find($userId);
        $this->modal = true;
    }
}
