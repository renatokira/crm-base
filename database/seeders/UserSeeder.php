<?php

namespace Database\Seeders;

use App\Enum\CanEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->withPermission(CanEnum::BE_AN_ADMIN)
            ->create([
                'name'  => 'Admin User',
                'email' => 'admin@example.com',
            ]);

        User::factory()
            ->create([
                'name'  => 'John Doe',
                'email' => 'test@example.com',
            ]);
    }
}
