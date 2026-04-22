<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentScore;
use App\Models\Course;
use App\Models\Material;
use App\Models\ProjectGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    // 1. Dashboard Siswa
    public function index()
    {
        $myCourses = Auth::user()->courses()->latest()->get();

        return view('siswa.dashboard', compact('myCourses'));
    }

    // 2. Katalog Kelas
    public function catalog()
    {
        $availableCourses = Course::whereDoesntHave('students', function ($query) {
            $query->where('users.id', Auth::id());
        })->latest()->get();

        return view('siswa.catalog', compact('availableCourses'));
    }

    // 3. Proses Gabung Kelas (Enroll)
    public function enroll(Course $course)
    {
        if (! Auth::user()->courses->contains($course->id)) {
            Auth::user()->courses()->attach($course->id);

            return redirect()->route('student.dashboard')->with('success', 'Berhasil bergabung ke kelas!');
        }

        return back()->with('error', 'Anda sudah terdaftar di kelas ini.');
    }

    // 4. Halaman Koridor Kelas (Overview)
    public function corridor(Course $course)
    {
        if (! Auth::user()->courses->contains($course->id)) {
            abort(403);
        }
        $teacher = \App\Models\User::find($course->teacher_id);
        $assignments = $course->assignments()->latest()->get();

        return view('siswa.corridor', compact('course', 'teacher', 'assignments'));
    }

    // 5. Halaman Mengerjakan Ujian / Proyek (YANG TADI TERPOTONG)
    public function showAssignment(Assignment $assignment)
    {
        $course = $assignment->course;
        if (! Auth::user()->courses->contains($course->id)) {
            abort(403);
        }

        if ($assignment->type == 'individual') {
            // Cek apakah siswa sudah pernah mengerjakan ujian ini
            $scoreRecord = AssignmentScore::where('assignment_id', $assignment->id)
                ->where('student_id', Auth::id())->first();

            $questions = \App\Models\AssignmentQuestion::where('assignment_id', $assignment->id)->get();

            return view('siswa.assignment_individual', compact('course', 'assignment', 'questions', 'scoreRecord'));
        } else {
            // Tampilan Proyek
            $myGroup = ProjectGroup::where('assignment_id', $assignment->id)
                ->whereHas('members', function ($q) {
                    $q->where('student_id', Auth::id());
                })->with('members')->first();

            return view('siswa.assignment_project', compact('course', 'assignment', 'myGroup'));
        }
    }

    // 6. Simpan Link Proyek (Oleh Siswa)
    public function updateProjectLinks(Request $request, ProjectGroup $group)
    {
        $request->validate([
            'monitoring_link' => 'nullable|url',
            'final_link' => 'nullable|url',
        ]);

        $group->update([
            'monitoring_link' => $request->monitoring_link,
            'final_link' => $request->final_link,
        ]);

        return back()->with('success', 'Link proyek berhasil disimpan!');
    }

    // 7. Hitung dan Simpan Nilai Ujian PG (BARU)
    public function submitIndividual(Request $request, Assignment $assignment)
    {
        $questions = \App\Models\AssignmentQuestion::where('assignment_id', $assignment->id)->get();
        $correctCount = 0;
        $totalQuestions = $questions->count();

        // Cek jawaban siswa vs kunci jawaban
        foreach ($questions as $q) {
            $userAnswer = $request->answers[$q->id] ?? null;
            if ($userAnswer === $q->correct_answer) {
                $correctCount++;
            }
        }

        // Hitung persentase nilai
        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;

        AssignmentScore::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'score' => $score,
        ]);

        return redirect()->route('student.corridor', $assignment->course_id)
            ->with('success', 'Ujian Selesai! Nilai Anda: '.$score);
    }

    // 8. Halaman Belajar Materi
    public function learn(Request $request, Course $course)
    {
        if (! Auth::user()->courses->contains($course->id)) {
            abort(403);
        }

        $course->load(['chapters.materials' => function ($q) {
            $q->orderBy('order_index');
        }]);

        $completedMaterialIds = DB::table('progress')
            ->where('student_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->pluck('material_id')
            ->toArray();

        $allMaterials = $course->chapters->flatMap->materials;
        $currentMaterialId = $request->query('material');

        if ($currentMaterialId) {
            $currentMaterial = $allMaterials->firstWhere('id', $currentMaterialId);
        } else {
            $currentMaterial = $allMaterials->first(function ($m) use ($completedMaterialIds) {
                return ! in_array($m->id, $completedMaterialIds);
            });
            $currentMaterial = $currentMaterial ?? $allMaterials->first();
        }

        $nextMaterial = null;
        if ($currentMaterial) {
            $currentIndex = $allMaterials->search(fn ($m) => $m->id === $currentMaterial->id);
            if ($currentIndex !== false && $currentIndex < $allMaterials->count() - 1) {
                $nextMaterial = $allMaterials->get($currentIndex + 1);
            }
        }

        return view('siswa.learning', compact('course', 'currentMaterial', 'completedMaterialIds', 'nextMaterial'));
    }

    // 9. Tandai Materi Selesai
    public function markComplete(Material $material)
    {
        if (! Auth::user()->courses->contains($material->course_id)) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        try {
            DB::table('progress')->updateOrInsert(
                [
                    'student_id' => Auth::id(),
                    'course_id' => $material->course_id,
                    'material_id' => $material->id,
                ],
                [
                    'is_completed' => true,
                    'updated_at' => now(),
                ]
            );

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
