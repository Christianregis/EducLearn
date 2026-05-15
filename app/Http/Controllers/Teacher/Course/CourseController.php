<?php

namespace App\Http\Controllers\Teacher\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreCoursesRequest;
use App\Http\Resources\Teacher\Courses\CourseResource;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        return Inertia::render('Teacher/Courses/Index', [
            'books' => CourseResource::collection(Course::with('enrollements')->where('teacher_id', Auth::user()->id)->latest()->get())
        ]);
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
            'description' => $data['description'],
            'format' => $data['format'],
            'color' => $data['color'],
            'icon' => $data['icon'],
            'category' => $data['category'],
            'level' => $data['level'],
        ]);

        return redirect()->back()->with('success', 'Cours créé avec succès.');
    }

    function delete(mixed $course_id)
    {
        $course = Course::where('id', $course_id)->firstOrFail();
        Storage::delete('/storage/' . $course->image);
        Storage::delete('/storage/' . $course->file);
        $course->delete();
        return redirect()->back()->with('success', 'Suppression reussie !');
    }
}
