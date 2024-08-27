<?php

namespace Database\Seeders;

use App\Enum\CanEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['key' => CanEnum::BE_AN_ADMIN->value]);
    }
}
