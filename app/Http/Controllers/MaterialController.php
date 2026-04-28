<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function edit(Material $material)
    {
        // Cari data kelas secara manual menggunakan course_id dari materi
        $course = Course::find($material->course_id);

        // Pastikan kelas ditemukan dan yang akses adalah guru pemilik kelas
        if (! $course || $course->teacher_id != Auth::id()) {
            abort(403);
        }

        // Kirim data material dan course ke view
        return view('guru.courses.edit_material', compact('material', 'course'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $material->update([
            'title' => $request->title,
            'content' => $request->input('content'), // <--- Gunakan input('content')
        ]);

        return redirect()->route('courses.curriculum', $material->course_id)
            ->with('success', 'Materi berhasil diperbarui!');
    }
}
