<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create(Chapter $chapter)
    {
        return view('guru.materials.create', compact('chapter'));
    }

    public function store(Request $request, Chapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        // Cari urutan terakhir
        $lastOrder = $chapter->materials()->max('order_index') ?? 0;

        // Simpan
        $chapter->materials()->create([
            'course_id' => $chapter->course_id,
            'title' => $request->title,

            // PERBAIKAN DI SINI:
            // Jangan pakai $request->content, tapi pakai $request->input('content')
            'content' => $request->input('content'),

            'order_index' => $lastOrder + 1,
        ]);

        return redirect()->route('courses.curriculum', $chapter->course_id)
            ->with('success', 'Materi berhasil disimpan!');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
