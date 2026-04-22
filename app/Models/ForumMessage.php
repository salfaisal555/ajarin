<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    protected $guarded = [];

    // Relasi ke Pengirim (User/Siswa/Guru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelas
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
