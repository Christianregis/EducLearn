<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Student\Product\ProductController;
use App\Http\Controllers\Teacher\Course\CourseController;
use App\Http\Resources\Teacher\Courses\CourseResource;
use App\Http\Resources\Teacher\Courses\CoursesDashboardResource;
use App\Models\Audio;
use App\Models\Course;
use App\Models\Enrollement;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get("/login", [AuthController::class, 'showLogin'])->name('showLogin');

Route::get("/catalog", [PublicController::class, 'catalog'])->name('catalog');

Route::post("/connexion", [AuthController::class, 'login'])->name('login');

Route::post("/logout", [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

Route::post('/inscription', [AuthController::class, 'register'])->name('register');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('Admin/Index');
    })->name('adminDashboard');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher', function () {

        $courses = [...Course::where('teacher_id', Auth::user()->id)->limit(5)->get(), ...Video::where('teacher_id', Auth::user()->id)->limit(5)->get(), ...Audio::where('teacher_id', Auth::user()->id)];

        return Inertia::render('Teacher/Index', [
            'statistics' => [
                'countCourses' => Course::where('teacher_id', Auth::user()->id)->count(),
                    + Audio::where('teacher_id', Auth::user()->id)->count(),
                    + Video::where('teacher_id', Auth::user()->id)->count(),
            ],

            'courses' => CoursesDashboardResource::collection($courses),
        ]);
    })->name('teacherDashboard');

    Route::get('/teacher/courses', [CourseController::class, 'index'])->name('teacherCourses');
    Route::get('/teacher/courses/create', [CourseController::class, 'create'])->name('teacherCoursesCreate');
    Route::post('/teacher/courses', [CourseController::class, 'store'])->name('teacherCoursesStore');

    Route::delete('/teacher/courses/pdf/{course_id}', [CourseController::class, 'deleteCourse'])->name('teacherCourseDelete');
    Route::delete('/teacher/courses/video/{course_id}', [CourseController::class, 'deleteVideo'])->name('teacherCourseVideoDelete');
    Route::delete('/teacher/courses/audi0/{course_id}', [CourseController::class, 'deleteAudio'])->name('teacherCourseAudioDelete');

    Route::get('/teacher/courses/videos', [CourseController::class, 'indexVideo'])->name('teacherCoursesVideos');
    Route::get('/teacher/courses/audios', [CourseController::class, 'indexAudio'])->name('teacherCoursesAudios');
});

Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student', function () {
        $courses = [...Course::where('teacher_id', Auth::user()->id)->limit(5)->get(), ...Video::where('teacher_id', Auth::user()->id)->limit(5)->get(), ...Audio::where('teacher_id', Auth::user()->id)->limit(5)->get()];

        $enrollements = Enrollement::with(['audios', 'video', 'audio', 'course'])->where('student_id', '=', Auth::user()->id)->get();

        return Inertia::render('Student/Index',[
            'courses' => CourseResource::collection($courses),
        ]);

    })->name('studentDashboard');

    Route::post('/student/courses/makeEnrollement', [ProductController::class, 'makeEnrollement'])->name('studentCoursesMakeEnrollement');

    Route::get('/student/courses', [ProductController::class, 'indexBooks'])->name('studentCourses');
    Route::get('/student/videos', [ProductController::class, 'indexVideos'])->name('studentVideos');
    Route::get('/student/audios', [ProductController::class, 'indexAudios'])->name('studentAudios');
});
