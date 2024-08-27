<?php

namespace App\Traits\Models;

use App\Enum\CanEnum;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermission
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(CanEnum|string $key)
    {
        $permissionKey = $key instanceof CanEnum ? $key->value : $key;

        $this->permissions()->firstOrCreate(['key' => $permissionKey]);

        Cache::forget($this->permissionCachedKey());
        Cache::rememberForever($this->permissionCachedKey(), fn () => $this->permissions);
    }

    public function hasPermissionTo(CanEnum|string $key): bool
    {
        $permissionKey = $key instanceof CanEnum ? $key->value : $key;

        $permissions = Cache::get($this->permissionCachedKey(), fn () => $this->permissions());

        return $permissions->where('key', '=', $permissionKey)->count() > 0;
    }

    private function permissionCachedKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
