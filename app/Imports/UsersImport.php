<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Abaikan jika baris excel kosong
        if (! isset($row['nama']) || ! isset($row['email'])) {
            return null;
        }

        // Cek apakah email sudah terdaftar agar tidak error duplicate
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        return new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'role' => isset($row['role']) ? strtolower($row['role']) : 'siswa',
            'password' => Hash::make('siswa123'), // Default Password!
        ]);
    }
}
