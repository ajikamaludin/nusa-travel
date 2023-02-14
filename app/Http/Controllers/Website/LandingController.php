<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index() 
    {
        Visitor::track([Visitor::class, 'LANDING_PAGE']);
        return view('welcome');
    }
}
