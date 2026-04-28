<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    // Hanya gunakan $fillable, HAPUS $guarded
    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'content',
        'type',
        'order_index',
    ];

    // Relasi: Materi milik 1 Bab
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // Relasi: Materi milik 1 Kelas (Tambahkan ini juga)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
