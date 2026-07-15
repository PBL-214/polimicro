<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;

// ---- PUBLIC ROUTES ----
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/faq', fn() => view('faq'))->name('faq');
Route::get('/verify-certificate/{nomor_sertifikat}', [\App\Http\Controllers\CertificateVerificationController::class, 'verify'])->name('verify.certificate');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:3,1');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/pending-verification', fn() => view('auth.pending-verification'))->name('pending-verification')->middleware('auth');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search')->middleware('auth');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
Route::post('/programs/enroll', [ProgramController::class, 'enroll'])->name('programs.enroll')->middleware('auth');

// ---- MAHASISWA ROUTES ----
Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::get('/expired', fn() => view('mahasiswa.expired'))->name('expired');
    Route::get('/dashboard', [\App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [\App\Http\Controllers\Mahasiswa\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{course}', [\App\Http\Controllers\Mahasiswa\CourseController::class, 'show'])->name('courses.show');
    
    // Forum Diskusi
    Route::get('/courses/{course}/forum', [\App\Http\Controllers\Mahasiswa\ForumController::class, 'index'])->name('courses.forum.index');
    Route::get('/courses/{course}/forum/{discussion}', [\App\Http\Controllers\Mahasiswa\ForumController::class, 'show'])->name('courses.forum.show');
    Route::post('/courses/{course}/forum', [\App\Http\Controllers\Mahasiswa\ForumController::class, 'store'])->name('courses.forum.store');
    Route::post('/courses/{course}/forum/{discussion}/reply', [\App\Http\Controllers\Mahasiswa\ForumController::class, 'reply'])->name('courses.forum.reply');

    // Kehadiran/Absensi
    Route::get('/courses/{course}/attendances', [\App\Http\Controllers\Mahasiswa\AttendanceController::class, 'index'])->name('courses.attendances.index');

    Route::get('/materials', [\App\Http\Controllers\Mahasiswa\MaterialController::class, 'index'])->name('materials');
    Route::get('/assignments', [\App\Http\Controllers\Mahasiswa\AssignmentController::class, 'index'])->name('assignments');
    Route::post('/assignments/submit', [\App\Http\Controllers\Mahasiswa\AssignmentController::class, 'submit'])->name('assignments.submit');
    Route::get('/grades', [\App\Http\Controllers\Mahasiswa\GradeController::class, 'index'])->name('grades');
    Route::get('/certificates', [\App\Http\Controllers\Mahasiswa\CertificateController::class, 'index'])->name('certificates');
    Route::get('/certificates/{id}/print', [\App\Http\Controllers\Mahasiswa\CertificateController::class, 'print'])->name('certificates.print');
    Route::get('/profile', [\App\Http\Controllers\Mahasiswa\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Mahasiswa\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Mahasiswa\ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/avatar', [\App\Http\Controllers\Mahasiswa\ProfileController::class, 'uploadAvatar'])->name('profile.avatar');

    // Quizzes for Mahasiswa
    Route::get('/courses/{course}/quizzes/{quiz}/take', [\App\Http\Controllers\Mahasiswa\QuizController::class, 'take'])->name('courses.quizzes.take');
    Route::post('/courses/{course}/quizzes/{quiz}/start', [\App\Http\Controllers\Mahasiswa\QuizController::class, 'start'])->name('courses.quizzes.start');
    Route::post('/courses/{course}/quizzes/{quiz}/submit', [\App\Http\Controllers\Mahasiswa\QuizController::class, 'submit'])->name('courses.quizzes.submit');
    Route::get('/courses/{course}/quizzes/attempt/{attempt}/result', [\App\Http\Controllers\Mahasiswa\QuizController::class, 'result'])->name('courses.quizzes.result');
});

// ---- DOSEN ROUTES ----
Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->name('dosen.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dosen\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [\App\Http\Controllers\Dosen\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{course}', [\App\Http\Controllers\Dosen\CourseController::class, 'show'])->name('courses.show');
    
    // Forum Diskusi
    Route::get('/courses/{course}/forum', [\App\Http\Controllers\Dosen\ForumController::class, 'index'])->name('courses.forum.index');
    Route::get('/courses/{course}/forum/{discussion}', [\App\Http\Controllers\Dosen\ForumController::class, 'show'])->name('courses.forum.show');
    Route::post('/courses/{course}/forum/{discussion}/reply', [\App\Http\Controllers\Dosen\ForumController::class, 'reply'])->name('courses.forum.reply');
    Route::post('/courses/{course}/forum/{discussion}/pin', [\App\Http\Controllers\Dosen\ForumController::class, 'togglePin'])->name('courses.forum.pin');
    Route::delete('/courses/{course}/forum/{discussion}', [\App\Http\Controllers\Dosen\ForumController::class, 'destroy'])->name('courses.forum.destroy');

    // Kehadiran/Absensi
    Route::get('/courses/{course}/attendances', [\App\Http\Controllers\Dosen\AttendanceController::class, 'index'])->name('courses.attendances.index');
    Route::get('/courses/{course}/attendances/create', [\App\Http\Controllers\Dosen\AttendanceController::class, 'create'])->name('courses.attendances.create');
    Route::post('/courses/{course}/attendances', [\App\Http\Controllers\Dosen\AttendanceController::class, 'store'])->name('courses.attendances.store');
    Route::get('/courses/{course}/attendances/{attendance}', [\App\Http\Controllers\Dosen\AttendanceController::class, 'show'])->name('courses.attendances.show');
    Route::put('/courses/{course}/attendances/{attendance}', [\App\Http\Controllers\Dosen\AttendanceController::class, 'update'])->name('courses.attendances.update');

    // Pengumuman
    Route::post('/courses/{course}/announcements', [\App\Http\Controllers\Dosen\AnnouncementController::class, 'store'])->name('courses.announcements.store');
    Route::delete('/courses/{course}/announcements/{announcement}', [\App\Http\Controllers\Dosen\AnnouncementController::class, 'destroy'])->name('courses.announcements.destroy');

    Route::get('/materials', [\App\Http\Controllers\Dosen\MaterialController::class, 'index'])->name('materials');
    Route::post('/materials', [\App\Http\Controllers\Dosen\MaterialController::class, 'store'])->name('materials.store');
    Route::put('/materials/{materi}', [\App\Http\Controllers\Dosen\MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{materi}', [\App\Http\Controllers\Dosen\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('/assignments', [\App\Http\Controllers\Dosen\AssignmentController::class, 'index'])->name('assignments');
    Route::post('/assignments', [\App\Http\Controllers\Dosen\AssignmentController::class, 'store'])->name('assignments.store');
    Route::put('/assignments/{tugas}', [\App\Http\Controllers\Dosen\AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{tugas}', [\App\Http\Controllers\Dosen\AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::get('/submissions', [\App\Http\Controllers\Dosen\SubmissionController::class, 'index'])->name('submissions');
    Route::put('/submissions/{submission}/grade', [\App\Http\Controllers\Dosen\SubmissionController::class, 'grade'])->name('submissions.grade');
    Route::get('/students', [\App\Http\Controllers\Dosen\StudentController::class, 'index'])->name('students');
    
    // Profil Dosen
    Route::get('/profile', [\App\Http\Controllers\Dosen\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Dosen\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Dosen\ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/avatar', [\App\Http\Controllers\Dosen\ProfileController::class, 'uploadAvatar'])->name('profile.avatar');

    // Quizzes for Dosen
    Route::resource('quizzes', \App\Http\Controllers\Dosen\QuizController::class);
});

// ---- ADMIN PIC ROUTES ----
Route::prefix('admin-pic')->middleware(['auth', 'role:admin_pic'])->name('admin-pic.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminPic\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/verification', [\App\Http\Controllers\AdminPic\VerificationController::class, 'index'])->name('verification');
    Route::put('/verification/{pendaftaran}', [\App\Http\Controllers\AdminPic\VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('/students', [\App\Http\Controllers\AdminPic\StudentController::class, 'index'])->name('students');
    Route::get('/students/export', [\App\Http\Controllers\AdminPic\StudentController::class, 'exportCsv'])->name('students.export');
    Route::get('/courses', [\App\Http\Controllers\AdminPic\CourseController::class, 'index'])->name('courses');
    Route::post('/courses', [\App\Http\Controllers\AdminPic\CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{makul}', [\App\Http\Controllers\AdminPic\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{makul}', [\App\Http\Controllers\AdminPic\CourseController::class, 'destroy'])->name('courses.destroy');
});

// ---- ADMIN AKADEMIK ROUTES ----
Route::prefix('admin-akademik')->middleware(['auth', 'role:admin_akademik'])->name('admin-akademik.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminAkademik\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/programs', [\App\Http\Controllers\AdminAkademik\ProgramController::class, 'index'])->name('programs');
    Route::post('/programs', [\App\Http\Controllers\AdminAkademik\ProgramController::class, 'store'])->name('programs.store');
    Route::put('/programs/{prodi}', [\App\Http\Controllers\AdminAkademik\ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{prodi}', [\App\Http\Controllers\AdminAkademik\ProgramController::class, 'destroy'])->name('programs.destroy');
    Route::get('/lecturers', [\App\Http\Controllers\AdminAkademik\LecturerController::class, 'index'])->name('lecturers');
    Route::get('/lecturers/export', [\App\Http\Controllers\AdminAkademik\LecturerController::class, 'exportCsv'])->name('lecturers.export');
    Route::post('/lecturers', [\App\Http\Controllers\AdminAkademik\LecturerController::class, 'store'])->name('lecturers.store');
    Route::put('/lecturers/{dosen}', [\App\Http\Controllers\AdminAkademik\LecturerController::class, 'update'])->name('lecturers.update');
    Route::delete('/lecturers/{dosen}', [\App\Http\Controllers\AdminAkademik\LecturerController::class, 'destroy'])->name('lecturers.destroy');
    Route::get('/certificates', [\App\Http\Controllers\AdminAkademik\CertificateController::class, 'index'])->name('certificates');
    Route::post('/certificates', [\App\Http\Controllers\AdminAkademik\CertificateController::class, 'store'])->name('certificates.store');
    Route::delete('/certificates/{sertifikat}', [\App\Http\Controllers\AdminAkademik\CertificateController::class, 'destroy'])->name('certificates.destroy');
    
    // Laporan
    Route::get('/reports', [\App\Http\Controllers\AdminAkademik\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/courses/{course}', [\App\Http\Controllers\AdminAkademik\ReportController::class, 'courseReport'])->name('reports.course');
    Route::get('/reports/courses/{course}/export', [\App\Http\Controllers\AdminAkademik\ReportController::class, 'exportCsv'])->name('reports.export');
});

// Notifications
Route::get('/notifications/{notification}/click', function($notification) {
    $notif = auth()->user()->notifications()->findOrFail($notification);
    $notif->markAsRead();
    return redirect($notif->data['url'] ?? route(auth()->user()->getDashboardRoute()));
})->middleware('auth')->name('notifications.click');

Route::post('/notifications/mark-all-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth')->name('notifications.markAllRead');
