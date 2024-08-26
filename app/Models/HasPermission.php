<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermission
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(string $key)
    {
        $this->permissions()->firstOrCreate(compact('key'));

        $cacheKey = $this->permissionCachedKey();
        Cache::forget($cacheKey);
        Cache::rememberForever($cacheKey, fn () => $this->permissions);
    }

    public function hasPermissionTo(string $key): bool
    {
        $cacheKey    = $this->permissionCachedKey();
        $permissions = Cache::get($cacheKey, fn () => $this->permissions());

        return $permissions->where('key', '=', $key)->count() > 0;
    }

    private function permissionCachedKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
