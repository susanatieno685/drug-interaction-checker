<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the initial admin user from the configured environment values.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME', 'Susan Atieno');
        $email = env('ADMIN_EMAIL', 'susanatieno@gmail.com');
        $password = env('ADMIN_PASSWORD');

        $attributes = [
            'name' => $name,
            'role' => 'admin',
        ];

        if ($password) {
            $attributes['password'] = Hash::make($password);
        }

        User::updateOrCreate(
            ['email' => $email],
            $attributes
        );
    }
}
