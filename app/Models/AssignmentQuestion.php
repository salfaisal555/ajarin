<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    // Baris ini sangat penting: Mengizinkan semua kolom diisi secara otomatis
    protected $guarded = [];

    // Relasi balik ke Assignment (Ujian)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
