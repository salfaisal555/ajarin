<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGroup extends Model
{
    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'content',
        'type',
        'order_index',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Anggota kelompok (Siswa)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_group_members', 'group_id', 'student_id');
    }
}
