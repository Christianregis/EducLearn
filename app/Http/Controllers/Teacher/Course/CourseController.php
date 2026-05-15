<?php

namespace App\Http\Controllers\Teacher\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreCoursesRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        return Inertia::render('Teacher/Courses/Index');
    }

    public function create()
    {
        return Inertia::render('Teacher/Courses/CreateCourse');
    }

    public function store(StoreCoursesRequest $request)
    {
        $data = $request->validated();

        $course = Course::create([
            'title' => $data['title'],
            'teacher_id' => Auth::user()->id,
            'duration' => $data['duration'],
            'price' => $data['price'] ?? null,
            'progress' => $data['progress'] ?? 0,
            'image' => $data['image']->store('courses/images', 'public'),
            'file' => $data['file']->store('courses/files', 'public'),
            'format' => $data['format'],
            'color' => $data['color'],
            'level' => $data['level'],
        ]);

        return redirect()->back()->with('success', 'Cours créé avec succès.');
    }
}
