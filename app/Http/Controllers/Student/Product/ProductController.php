<?php

namespace App\Http\Controllers\Student\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
