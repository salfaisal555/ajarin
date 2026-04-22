<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    // Relasi: Materi milik 1 Bab
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
