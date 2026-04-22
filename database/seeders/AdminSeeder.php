<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Buat 1 Guru untuk tes
        User::create([
            'name' => 'Bapak Guru',
            'email' => 'guru@lms.com',
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);

        // Buat 1 Siswa untuk tes
        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@lms.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);
    }
}
