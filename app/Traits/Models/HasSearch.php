<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search = null, ?array $columns = []): void
    {
        $query->when($search, function (Builder $query) use ($search, $columns) {
            foreach ((array) $columns as $column) {
                $query->orWhere(
                    DB::raw("lower({$column})"),
                    'like',
                    '%' . strtolower($search) . '%'
                );
            }
        });
    }
}
