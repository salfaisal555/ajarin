<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = []; // Izinkan semua kolom

    // Relasi: 1 Kelas punya banyak Bab
    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('order_index');
    }

    // Relasi: 1 Kelas punya banyak Siswa (Lewat tabel pivot enrollment, nanti kita bahas)
    // Untuk sementara kita skip siswa dulu agar fokus ke materi
    public function students()
    {
        // Asumsi kamu pakai role 'siswa', relasinya bisa many-to-many atau hasMany enrollments
        // Kita pakai dummy relation dulu agar tidak error di controller
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class)->latest();
    }

    public function forumMessages()
    {
        return $this->hasMany(ForumMessage::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
