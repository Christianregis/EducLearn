<?php

namespace App\Http\Controllers;

use App\Http\Resources\Public\Course\CatalogResource;
use App\Models\Audio;
use App\Models\Course;
use App\Models\Video;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function home()
    {
        return Inertia::render('Welcome');
    }

    public function catalog()
    {
        $products = [
            ...Course::with('enrollements')->latest()->get(),
            ...Video::with('enrollements')->latest()->get(),
            ...Audio::with('enrollements')->latest()->get(),
        ];
        return Inertia::render('Catalog',[
            'products' => CatalogResource::collection($products),
        ]);
    }
}
