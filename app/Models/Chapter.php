<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $guarded = [];

    // Relasi: Bab milik 1 Kelas
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi: 1 Bab punya banyak Materi (PENTING INI)
    public function materials()
    {
        return $this->hasMany(Material::class)->orderBy('order_index');
    }
}
