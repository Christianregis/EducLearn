<?php

namespace App\Http\Controllers\Student\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollement\StoreEnrollementRequest;
use App\Http\Resources\Student\Enrollement\EnrollementResource;
use App\Models\Enrollement;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function indexBooks()
    {
        $student = Auth::user();
        $courses = $student->enrollements()->with('course')->latest()->get();
        return Inertia::render('Student/Cours/Book', [
            'books' => EnrollementResource::collection($courses),
        ]);
    }

    public function indexVideos()
    {
        $student = Auth::user();

        $courses = $student->enrollements()
            ->whereHas('video')
            ->with('video')
            ->latest()
            ->get();

        return Inertia::render('Student/Cours/Videos', [
            'video' => EnrollementResource::collection($courses),
        ]);
    }

    public function indexAudios()
    {
        $student = Auth::user();
        $courses = $student->enrollements()->with('audio')->latest()->get();
        return Inertia::render('Student/Cours/Audio', [
            'audios' => EnrollementResource::collection($courses),

        ]);
    }

    public function makeEnrollement(StoreEnrollementRequest $request)
    {
        $data = $request->validated();
        Enrollement::firstOrcreate([
            'student_id' => Auth::user()->id,
            'audio_id' => $data['audio_id'] ?? null,
            'video_id' => $data['video_id'] ?? null,
            'course_id' => $data['course_id'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Votre enrollement a ete effectue avec succes !');
    }
}
