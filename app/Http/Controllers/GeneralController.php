<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class GeneralController extends Controller
{
    public function index(): Response
    {
        return inertia('Dashboard');
    }

    public function indev(): Response
    {
        return inertia('Dev');
    }
}
