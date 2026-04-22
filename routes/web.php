<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

    // 2. User Management (Admin)
    Route::resource('users', UserController::class);

    // 3. Course Management (Guru)
    Route::resource('courses', CourseController::class);
    // ROUTE BARU: Halaman khusus untuk menyusun materi (Step 2 setelah buat kelas)
    Route::get('/courses/{course}/curriculum', [CourseController::class, 'editCurriculum'])->name('courses.curriculum');
    // Route Bab & Materi (Tetap sama)
    Route::post('/courses/{course}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::put('/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');

    Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::get('/chapters/{chapter}/materials/create', [MaterialController::class, 'create'])->name('materials.create');
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
    Route::post('/progress/complete/{material}', [App\Http\Controllers\StudentController::class, 'markComplete'])->name('student.complete');
    // ROUTE MANAJEMEN UJIAN & PROYEK
    Route::get('/courses/{course}/assignments/create/{type}', [App\Http\Controllers\AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/courses/{course}/assignments/individual', [App\Http\Controllers\AssignmentController::class, 'storeIndividual'])->name('assignments.store_individual');
    Route::post('/courses/{course}/assignments/project', [App\Http\Controllers\AssignmentController::class, 'storeProject'])->name('assignments.store_project');
    // ROUTE CRUD UJIAN & PROYEK
    Route::get('/assignments/{assignment}/edit', [App\Http\Controllers\AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [App\Http\Controllers\AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [App\Http\Controllers\AssignmentController::class, 'destroy'])->name('assignments.destroy');

    // Route Khusus Siswa
    Route::middleware(['auth'])->group(function () {
        Route::get('/student/dashboard', [App\Http\Controllers\StudentController::class, 'index'])->name('student.dashboard');
        Route::get('/student/catalog', [App\Http\Controllers\StudentController::class, 'catalog'])->name('student.catalog');
        Route::post('/student/enroll/{course}', [App\Http\Controllers\StudentController::class, 'enroll'])->name('student.enroll');
        // ROUTE BARU: Koridor Kelas
        Route::get('/student/course/{course}/corridor', [App\Http\Controllers\StudentController::class, 'corridor'])->name('student.corridor');
        // Route Belajar (Nanti)
        Route::get('/learning/{course}', [App\Http\Controllers\StudentController::class, 'learn'])->name('student.learning');
        // ROUTE UJIAN & PROYEK (SISWA)
        Route::get('/student/assignment/{assignment}', [App\Http\Controllers\StudentController::class, 'showAssignment'])->name('student.assignment.show');
        Route::put('/student/project-group/{group}/links', [App\Http\Controllers\StudentController::class, 'updateProjectLinks'])->name('student.project.links');
        // ROUTE BARU UNTUK SUBMIT UJIAN PG
        Route::post('/student/assignment/{assignment}/submit', [App\Http\Controllers\StudentController::class, 'submitIndividual'])->name('student.assignment.submit');
        // ROUTE PENILAIAN PROYEK (GURU)
        Route::post('/assignments/group/{group}/grade', [App\Http\Controllers\AssignmentController::class, 'gradeProject'])->name('assignments.grade_project');
    });
    // ROUTE FORUM DISKUSI (Bisa diakses Guru & Siswa)
    Route::get('/courses/{course}/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum.index');
    Route::post('/courses/{course}/forum', [App\Http\Controllers\ForumController::class, 'store'])->name('forum.store');
    Route::get('/courses/{course}/forum/messages', [App\Http\Controllers\ForumController::class, 'fetchMessages'])->name('forum.fetch_messages');

});

require __DIR__.'/auth.php';
