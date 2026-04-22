<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ForumMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Menampilkan halaman chat forum
    public function index(Course $course)
    {
        // Pastikan hanya Guru kelas ini ATAU Siswa kelas ini yang bisa masuk
        $isTeacher = $course->teacher_id == Auth::id();
        $isStudent = Auth::user()->courses->contains($course->id);

        if (! $isTeacher && ! $isStudent) {
            abort(403, 'Anda tidak memiliki akses ke forum kelas ini.');
        }

        // Ambil pesan dari yang terlama ke terbaru (Gaya Chatting)
        $messages = $course->forumMessages()->with('user')->oldest()->get();

        return view('forum.index', compact('course', 'messages', 'isTeacher'));
    }

    // Mengirim pesan baru
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        ForumMessage::create([
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }

    // FUNGSI BARU: Mengambil hanya bagian pesan (untuk AJAX)
    public function fetchMessages(Course $course)
    {
        $isTeacher = $course->teacher_id == Auth::id();
        $messages = $course->forumMessages()->with('user')->oldest()->get();

        // Kita akan membuat file blade 'partial' yang isinya khusus perulangan pesan saja
        return view('forum.partials.messages', compact('course', 'messages', 'isTeacher'));
    }
}
