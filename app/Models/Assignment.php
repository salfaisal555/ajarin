<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = [];

    // Jika tipenya 'project', maka punya banyak kelompok
    public function groups()
    {
        return $this->hasMany(ProjectGroup::class);
    }

    // TAMBAHKAN RELASI INI: Setiap assignment milik 1 course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi ke soal pilihan ganda
    public function questions()
    {
        return $this->hasMany(AssignmentQuestion::class);
    }

    // Relasi ke nilai siswa
    public function scores()
    {
        return $this->hasMany(AssignmentScore::class);
    }
}
