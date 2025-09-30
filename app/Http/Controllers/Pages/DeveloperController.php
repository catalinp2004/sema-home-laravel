<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DeveloperController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Developer');
    }
}
