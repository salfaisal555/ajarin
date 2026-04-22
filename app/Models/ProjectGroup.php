<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGroup extends Model
{
    protected $guarded = [];

    // Anggota kelompok (Siswa)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_group_members', 'group_id', 'student_id');
    }
}
