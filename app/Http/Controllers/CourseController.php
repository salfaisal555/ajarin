<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())->latest()->get();

        return view('guru.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('guru.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = new Course;
        $course->teacher_id = Auth::id();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->save();

        // PERUBAHAN: Setelah buat kelas, langsung arahkan ke halaman susun materi
        return redirect()->route('courses.curriculum', $course->id)->with('success', 'Info kelas disimpan. Silakan susun materi sekarang.');
    }

    // METHOD BARU: Halaman untuk Edit Materi (Bab & Konten)
    public function editCurriculum(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        // PENTING: load('chapters.materials') agar materi terpanggil di view
        // Gunakan fungsi callback untuk memastikan urutannya benar
        $course->load(['chapters' => function ($q) {
            $q->orderBy('order_index')->with(['materials' => function ($q2) {
                $q2->orderBy('order_index');
            }]);
        }]);

        return view('guru.courses.curriculum', compact('course'));
    }

    // METHOD SHOW (MONITORING KELAS) - INI YANG KITA UBAH TOTAL
    public function show(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        // 1. Ambil Siswa yang enroll di kelas ini
        // Kita hitung progress mereka sekalian
        $students = $course->students()->get()->map(function ($student) use ($course) {

            // Hitung Total Item (Materi + Tugas) di kelas ini
            $totalItems = DB::table('materials')
                ->join('chapters', 'materials.chapter_id', '=', 'chapters.id')
                ->where('chapters.course_id', $course->id)
                ->count();

            // Hitung Item yang sudah diselesaikan siswa
            $completedItems = DB::table('progress')
                ->where('student_id', $student->id)
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();

            // Kalkulasi Persentase
            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

            $student->progress_percent = $progress;

            return $student;
        });

        // 2. Ambil Data Kelompok (Jika ada tugas kelompok)
        // Asumsi: Kita ambil kelompok dari assignment terakhir/semua assignment
        // Untuk simpelnya, kita ambil logic assignment project nanti.

        return view('guru.courses.monitoring', compact('course', 'students'));
    }

    public function destroy(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }
        $course->delete();

        return redirect()->route('courses.index');
    }

    public function update(Request $request, Course $course)
    {
        // Pastikan yang edit adalah pemilik kelas
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Informasi kelas berhasil diperbarui!');
    }
}
