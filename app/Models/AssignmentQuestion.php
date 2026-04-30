<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'content',
        'type',
        'order_index',
    ];

    // Relasi balik ke Assignment (Ujian)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
