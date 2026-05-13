<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PublicController;
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
        return Inertia::render('Teacher/Index');
    })->name('teacherDashboard');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student', function () {
        return Inertia::render('Student/Index');
    })->name('studentDashboard');
});

Route::get('/catalog', function () {
    return Inertia::render('Catalog');
})->name('catalog');
