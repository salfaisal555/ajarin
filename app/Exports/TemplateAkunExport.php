<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateAkunExport implements FromArray, WithHeadings
{
    // Judul Kolom (Baris 1)
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Role (guru/siswa)',
        ];
    }

    // Isi Data Contoh (Baris 2 dst)
    public function array(): array
    {
        return [
            ['Budi Santoso', 'budi@sekolah.com', 'siswa'],
            ['Siti Aminah', 'siti@sekolah.com', 'guru'],
        ];
    }
}
