<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function home()
    {
        return Inertia::render('Welcome');
    }

    public function catalog()
    {
        return Inertia::render('Catalog');
    }
}
