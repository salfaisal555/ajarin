<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// GRUP ROUTE YANG BUTUH LOGIN (AUTH)
Route::middleware('auth')->group(function () {

    // 1. Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('/users/template', [UserController::class, 'downloadTemplate'])->name('users.download_template');
    // 2. User Management (Admin)
    Route::resource('users', UserController::class);

    Route::get('/force-change-password', function () {
        return view('auth.force-change');
    })->name('password.force_change');

    Route::post('/force-change-password', function (Request $request) {
        $request->validate([
            'password' => 'required|min:8|confirmed', // Butuh input 'password' dan 'password_confirmation'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/dashboard')->with('success', 'Password berhasil diamankan! Selamat datang.');
    })->name('password.force_update');
    // 3. Course Management (Guru)
    Route::resource('courses', CourseController::class);
    // ROUTE BARU: Halaman khusus untuk menyusun materi (Step 2 setelah buat kelas)
    Route::get('/courses/{course}/curriculum', [CourseController::class, 'editCurriculum'])->name('courses.curriculum');
    // Route Bab & Materi (Tetap sama)
    Route::post('/courses/{course}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::put('/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
    // Route Export Data Monitoring
    Route::get('/courses/{course}/export', [CourseController::class, 'exportProgress'])->name('courses.export');

    Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::get('/chapters/{chapter}/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
    Route::post('/chapters/{chapter}/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

    // 4. Chapter Management (Bab)
    Route::post('/courses/{course}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');

    // 5. Material Management (Materi)
    Route::get('/chapters/{chapter}/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/chapters/{chapter}/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    // Route update progress via AJAX
    Route::post('/progress/complete/{material}', [StudentController::class, 'markComplete'])->name('student.complete');
    // ROUTE MANAJEMEN UJIAN & PROYEK
    Route::get('/courses/{course}/assignments/create/{type}', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/courses/{course}/assignments/individual', [AssignmentController::class, 'storeIndividual'])->name('assignments.store_individual');
    Route::post('/courses/{course}/assignments/project', [AssignmentController::class, 'storeProject'])->name('assignments.store_project');
    // ROUTE CRUD UJIAN & PROYEK
    Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Route Khusus Siswa
    Route::middleware(['auth'])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
        Route::get('/student/catalog', [StudentController::class, 'catalog'])->name('student.catalog');
        Route::post('/student/enroll/{course}', [StudentController::class, 'enroll'])->name('student.enroll');
        // ROUTE BARU: Koridor Kelas
        Route::get('/student/course/{course}/corridor', [StudentController::class, 'corridor'])->name('student.corridor');
        // Route Belajar (Nanti)
        Route::get('/learning/{course}', [StudentController::class, 'learn'])->name('student.learning');
        // ROUTE UJIAN & PROYEK (SISWA)
        Route::get('/student/assignment/{assignment}', [StudentController::class, 'showAssignment'])->name('student.assignment.show');
        Route::put('/student/project-group/{group}/links', [StudentController::class, 'updateProjectLinks'])->name('student.project.links');
        // ROUTE BARU UNTUK SUBMIT UJIAN PG
        Route::post('/student/assignment/{assignment}/submit', [StudentController::class, 'submitIndividual'])->name('student.assignment.submit');
        // ROUTE PENILAIAN PROYEK (GURU)
        Route::post('/assignments/group/{group}/grade', [AssignmentController::class, 'gradeProject'])->name('assignments.grade_project');
    });
    // ROUTE FORUM DISKUSI (Bisa diakses Guru & Siswa)
    Route::get('/courses/{course}/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::post('/courses/{course}/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/courses/{course}/forum/messages', [ForumController::class, 'fetchMessages'])->name('forum.fetch_messages');

});

require __DIR__.'/auth.php';
