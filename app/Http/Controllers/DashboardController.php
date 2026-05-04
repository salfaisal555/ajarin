<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return view('dashboard', [
                'totalSiswa' => User::where('role', 'siswa')->count(),
                'totalGuru' => User::where('role', 'guru')->count(),
                'totalKelas' => Course::count(),
                'latestUsers' => User::latest()->take(5)->get(),
            ]);
        }

        if ($user->role == 'guru') {
            $courses = Course::where('teacher_id', $user->id)->withCount('students')->latest()->get();
            $totalKelas = $courses->count();
            $totalSiswa = $courses->sum('students_count');
            $totalTugas = Assignment::whereIn('course_id', $courses->pluck('id'))->count();

            return view('dashboard', compact('courses', 'totalKelas', 'totalSiswa', 'totalTugas'));
        }

        if ($user->role == 'siswa') {
            $myCourses = $user->courses()->get();
            $totalKelasSiswa = $myCourses->count();

            // Hitung tugas aktif: assignment di kelas yang diikuti & deadline belum lewat & belum dikerjakan
            $enrolledCourseIds = $myCourses->pluck('id');
            $tugasAktif = Assignment::whereIn('course_id', $enrolledCourseIds)
                ->where('deadline', '>=', now())
                ->where(function ($q) use ($user) {
                    // Belum ada score record untuk siswa ini
                    $q->whereDoesntHave('scores', function ($sq) use ($user) {
                        $sq->where('student_id', $user->id);
                    });
                })
                ->count();

            // Hitung total materi selesai sebagai "poin belajar"
            $poinBelajar = DB::table('progress')
                ->where('student_id', $user->id)
                ->where('is_completed', true)
                ->count();

            // Ambil kelas beserta progress masing-masing untuk ditampilkan
            $coursesWithProgress = $myCourses->map(function ($course) use ($user) {
                $totalItems = DB::table('materials')
                    ->join('chapters', 'materials.chapter_id', '=', 'chapters.id')
                    ->where('chapters.course_id', $course->id)
                    ->count();

                $completedItems = DB::table('progress')
                    ->where('student_id', $user->id)
                    ->where('course_id', $course->id)
                    ->where('is_completed', true)
                    ->count();

                $course->progress_percent = $totalItems > 0
                    ? round(($completedItems / $totalItems) * 100)
                    : 0;

                return $course;
            });

            return view('dashboard', compact(
                'coursesWithProgress',
                'totalKelasSiswa',
                'tugasAktif',
                'poinBelajar'
            ));
        }

        return view('dashboard');
    }
}
