<?php

namespace App\Providers;

use App\Enum\CanEnum;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        foreach (CanEnum::cases() as $can) {
            Gate::define(
                $can->value,
                fn (User $user) => $user->hasPermissionTo($can)
            );
        }
    }
}
