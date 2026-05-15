<?php

namespace App\Http\Controllers\Teacher\Course;

use App\Enum\Course\CourseTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreCoursesRequest;
use App\Http\Resources\Teacher\Courses\CourseResource;
use App\Models\Audio;
use App\Models\Course;
use App\Models\Video;
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

    public function indexVideo()
    {
        return Inertia::render('Teacher/Video/Index', [
            'books' => CourseResource::collection(Video::with('enrollements')->where('teacher_id', Auth::user()->id)->latest()->get())
        ]);
    }

    public function indexAudio()
    {
        return Inertia::render('Teacher/Audio/Index', [
            'books' => CourseResource::collection(Audio::with('enrollements')->where('teacher_id', Auth::user()->id)->latest()->get())
        ]);
    }

    public function create()
    {
        return Inertia::render('Teacher/Courses/CreateCourse');
    }

    public function store(StoreCoursesRequest $request)
    {
        $data = $request->validated();

        if ($data['format'] == CourseTypeEnum::PDF->value) {
            $course = Course::create([
                'title' => $data['title'],
                'teacher_id' => Auth::user()->id,
                'duration' => $data['duration'],
                'price' => $data['price'] ?? null,
                'progress' => $data['progress'] ?? 0,
                'image' => $data['image']->store('courses/images', 'public'),
                'file' => $data['file']->store('courses/files', 'public'),
                'description' => $data['description'],
                'format' => CourseTypeEnum::PDF,
                'color' => $data['color'],
                'icon' => $data['icon'],
                'category' => $data['category'],
                'level' => $data['level'],
            ]);
        } else if ($data['format'] == CourseTypeEnum::AUDIO->value) {
            $course = Audio::create([
                'title' => $data['title'],
                'teacher_id' => Auth::user()->id,
                'duration' => $data['duration'],
                'price' => $data['price'] ?? null,
                'progress' => $data['progress'] ?? 0,
                'image' => $data['image']->store('courses/images', 'public'),
                'file' => $data['file']->store('courses/files', 'public'),
                'description' => $data['description'],
                'format' => CourseTypeEnum::AUDIO,
                'color' => $data['color'],
                'icon' => $data['icon'],
                'category' => $data['category'],
                'level' => $data['level'],
            ]);
        } else if ($data['format'] == CourseTypeEnum::VIDEO->value) {
            $course = Video::create([
                'title' => $data['title'],
                'teacher_id' => Auth::user()->id,
                'duration' => $data['duration'],
                'price' => $data['price'] ?? null,
                'progress' => $data['progress'] ?? 0,
                'image' => $data['image']->store('courses/images', 'public'),
                'file' => $data['file']->store('courses/files', 'public'),
                'description' => $data['description'],
                'format' => CourseTypeEnum::VIDEO,
                'color' => $data['color'],
                'icon' => $data['icon'],
                'category' => $data['category'],
                'level' => $data['level'],
            ]);
        } else {
            abort(403);
        }

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
