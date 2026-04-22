<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate(['title' => 'required|string|max:255']);

        // Cari urutan terakhir
        $lastOrder = $course->chapters()->max('order_index') ?? 0;

        $course->chapters()->create([
            'title' => $request->title,
            'order_index' => $lastOrder + 1,
        ]);

        return back()->with('success', 'Bab berhasil ditambahkan!');
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return back()->with('success', 'Bab berhasil dihapus.');
    }

    public function update(Request $request, Chapter $chapter)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $chapter->update([
            'title' => $request->title,
        ]);

        return back()->with('success', 'Nama Bab berhasil diperbarui!');
    }
}
