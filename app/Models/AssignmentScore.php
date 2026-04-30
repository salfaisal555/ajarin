<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentScore extends Model
{
    // Mengizinkan penyimpanan ke semua kolom
    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'content',
        'type',
        'order_index',
    ];

    // Relasi balik ke tabel Assignments (Ujian/Proyek)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Relasi balik ke tabel Users (Siswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
