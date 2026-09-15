<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas SIPESAT',
                'password' => Hash::make('Petugas123'),
                'role_id' => 2,
                'is_active' => true,
            ]
        );
    }
}