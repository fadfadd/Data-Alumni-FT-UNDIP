<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL');
        $password = env('SEED_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->error('Dilewati: isi SEED_ADMIN_EMAIL dan SEED_ADMIN_PASSWORD di .env dulu');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make($password),
                'role' => User::ROLE_SUPER_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ]
        );

        $this->command->info("Siap: Admin Utama ({$email})");
    }
}