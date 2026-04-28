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

    // METHOD BARU: Export Data Progress Siswa ke CSV
    public function exportProgress(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        $students = $course->students()->get()->map(function ($student) use ($course) {

            // Hitung Progress
            $totalItems = DB::table('materials')
                ->join('chapters', 'materials.chapter_id', '=', 'chapters.id')
                ->where('chapters.course_id', $course->id)
                ->count();

            $completedItems = DB::table('progress')
                ->where('student_id', $student->id)
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();

            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
            $student->progress_percent = $progress;

            // HITUNG RATA-RATA NILAI SISWA DI KELAS INI
            $avgScore = DB::table('assignment_scores')
                ->join('assignments', 'assignment_scores.assignment_id', '=', 'assignments.id')
                ->where('assignments.course_id', $course->id)
                ->where('assignment_scores.student_id', $student->id)
                ->avg('assignment_scores.score');

            $student->average_score = $avgScore ? round($avgScore, 2) : 0;

            return $student;
        });

        $fileName = 'Rekap_Nilai_'.preg_replace('/[^A-Za-z0-9\-]/', '_', $course->title).'_'.date('Y-m-d').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // TAMBAHKAN 'Rata-rata Nilai' DI JUDUL KOLOM EXCEL
        $columns = ['No', 'Nama Siswa', 'Email', 'Progress (%)', 'Rata-rata Nilai', 'Status Penyelesaian'];

        $callback = function () use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $no = 1;
            foreach ($students as $student) {
                $status = $student->progress_percent == 100 ? 'Selesai' : 'Belum Selesai';

                $row = [
                    $no++,
                    $student->name,
                    $student->email,
                    $student->progress_percent.'%',
                    $student->average_score, // Masukkan nilai ke baris Excel
                    $status,
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
