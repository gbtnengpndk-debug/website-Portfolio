<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;

class PortfolioController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        $skills = Skill::all();
        $profilePhoto = Setting::profilePhotoUrl();

        return view('portfolio', compact('projects', 'skills', 'profilePhoto'));
    }
}