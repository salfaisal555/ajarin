<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentQuestion;
use App\Models\Course;
use App\Models\ProjectGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    // 1. Menampilkan Form berdasarkan tipe
    public function create(Course $course, $type)
    {
        // Pastikan yang akses adalah gurunya
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        if ($type === 'individual') {
            return view('guru.assignments.create_individual', compact('course'));
        } elseif ($type === 'project') {
            // Ambil daftar siswa yang enroll di kelas ini untuk dibagi kelompok
            $students = $course->students()->get();

            return view('guru.assignments.create_project', compact('course', 'students'));
        }
        abort(404);
    }

    // 2. Simpan Ujian Individual (Pilihan Ganda)
    public function storeIndividual(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'questions' => 'required|array|min:1',
        ]);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'type' => 'individual',
            'deadline' => $request->deadline,
        ]);

        foreach ($request->questions as $q) {
            AssignmentQuestion::create([
                'assignment_id' => $assignment->id,
                'question' => $q['question'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
            ]);
        }

        return redirect()->route('courses.show', $course->id)->with('success', 'Ujian Individual berhasil dibuat!');
    }

    // 3. Simpan Proyek Kelompok
    public function storeProject(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'groups' => 'required|array|min:1',
            'groups.*.name' => 'required|string',
            'groups.*.students' => 'required|array|min:1',
        ]);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'type' => 'project',
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        foreach ($request->groups as $g) {
            $group = ProjectGroup::create([
                'assignment_id' => $assignment->id,
                'name' => $g['name'],
            ]);
            // Masukkan siswa-siswa yang dipilih ke kelompok ini
            $group->members()->attach($g['students']);
        }

        return redirect()->route('courses.show', $course->id)->with('success', 'Proyek Kelompok berhasil dibuat!');
    }

    // 4. Form Edit Ujian / Proyek
    public function edit(Assignment $assignment)
    {
        $course = $assignment->course;
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        if ($assignment->type === 'individual') {
            $assignment->load('questions');

            return view('guru.assignments.edit_individual', compact('course', 'assignment'));
        } else {
            $assignment->load('groups.members');
            $students = $course->students()->get();

            return view('guru.assignments.edit_project', compact('course', 'assignment', 'students'));
        }
    }

    // 5. Proses Update Data
    public function update(Request $request, Assignment $assignment)
    {
        $course = $assignment->course;
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        // Update Data Utama
        $assignment->update([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'description' => $request->description ?? $assignment->description,
        ]);

        if ($assignment->type === 'individual') {
            // Update Soal PG (Amankan ID lama, tambah baru, hapus yg tak ada)
            $keptQuestionIds = [];
            foreach ($request->questions as $q) {
                if (isset($q['id'])) {
                    // Update soal yang sudah ada
                    $question = \App\Models\AssignmentQuestion::find($q['id']);
                    $question->update($q);
                    $keptQuestionIds[] = $question->id;
                } else {
                    // Tambah soal baru
                    $newQ = $assignment->questions()->create($q);
                    $keptQuestionIds[] = $newQ->id;
                }
            }
            // Hapus soal yang dibuang guru di form edit
            $assignment->questions()->whereNotIn('id', $keptQuestionIds)->delete();

        } elseif ($assignment->type === 'project') {
            // Update Kelompok Proyek
            $keptGroupIds = [];
            if ($request->groups) {
                foreach ($request->groups as $g) {
                    if (isset($g['id'])) {
                        $group = \App\Models\ProjectGroup::find($g['id']);
                        $group->update(['name' => $g['name']]);
                        $group->members()->sync($g['students'] ?? []); // Sync update anggota
                        $keptGroupIds[] = $group->id;
                    } else {
                        $newGroup = \App\Models\ProjectGroup::create([
                            'assignment_id' => $assignment->id,
                            'name' => $g['name'],
                        ]);
                        $newGroup->members()->attach($g['students'] ?? []);
                        $keptGroupIds[] = $newGroup->id;
                    }
                }
            }
            // Hapus kelompok yang dibuang
            $assignment->groups()->whereNotIn('id', $keptGroupIds)->delete();
        }

        return redirect()->route('courses.show', $course->id)->with('success', 'Data Ujian/Proyek berhasil diperbarui!');
    }

    // 6. Proses Hapus Data
    public function destroy(Assignment $assignment)
    {
        if ($assignment->course->teacher_id != Auth::id()) {
            abort(403);
        }
        $assignment->delete(); // Otomatis menghapus soal & kelompok (karena ON DELETE CASCADE di SQL)

        return back()->with('success', 'Ujian/Proyek berhasil dihapus.');
    }

    // 7. Berikan Nilai untuk Proyek Kelompok
    public function gradeProject(Request $request, \App\Models\ProjectGroup $group)
    {
        // Validasi nilai harus antara 0 sampai 100
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        // Cek izin (opsional, pastikan guru yang berhak)
        $course = $group->assignment->course;
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        // Loop semua anggota kelompok, dan berikan nilai yang sama ke tabel assignment_scores
        foreach ($group->members as $student) {
            \App\Models\AssignmentScore::updateOrInsert(
                [
                    'assignment_id' => $group->assignment_id,
                    'student_id' => $student->id,
                ],
                [
                    'score' => $request->score,
                    'updated_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Nilai kelompok '.$group->name.' berhasil disimpan!');
    }
}
