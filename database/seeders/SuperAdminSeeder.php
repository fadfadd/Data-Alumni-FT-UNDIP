<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['name' => 'Admin Utama', 'email' => env('SEED_ADMIN_EMAIL'), 'password' => env('SEED_ADMIN_PASSWORD')],
            ['name' => 'Developer',   'email' => env('SEED_DEV_EMAIL'),   'password' => env('SEED_DEV_PASSWORD')],
        ];

        foreach ($akun as $a) {
            if (! $a['email'] || ! $a['password']) {
                $this->command->error("Dilewati: {$a['name']} (isi email dan password-nya di .env dulu)");
                continue;
            }

            User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make($a['password']),
                    'role' => User::ROLE_SUPER_ADMIN,
                    'status' => User::STATUS_ACTIVE,
                ]
            );

            $this->command->info("Siap: {$a['name']} ({$a['email']})");
        }
    }
}