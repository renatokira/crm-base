<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Illuminate\Validation\{ValidationException};
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public ?string $email = null;

    public ?string $password = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {

        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            throw ValidationException::withMessages([
                'rateLimiter' => trans('auth.throttle', ['seconds' => RateLimiter::availableIn($this->throttleKey())]),
            ]);
        };

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'invalidCredentials' => trans('auth.failed'),
            ]);
        };

        $this->redirect(route('welcome'));
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
