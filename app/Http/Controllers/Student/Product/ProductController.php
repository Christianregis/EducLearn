<?php

namespace App\Http\Controllers\Student\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollement\StoreEnrollementRequest;
use App\Models\Enrollement;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function indexBooks()
    {
        return Inertia::render('Student/Cours/Book');
    }

    public function indexVideos()
    {
        return Inertia::render('Student/Cours/Videos');
    }

    public function indexAudios()
    {
        return Inertia::render('Student/Cours/Audio');
    }

    public function makeEnrollement(StoreEnrollementRequest $request)
    {
        $data = $request->validated();
        Enrollement::create([
            'student_id' => Auth::user()->id,
            'audio_id' => $data['audio_id'] ?? null,
            'video_id' => $data['video_id'] ?? null,
            'course_id' => $data['course_id'] ?? null
        ]);

        return redirect()->back()->with('success', 'Votre enrollement a ete effectue avec succes !');
    }
}
