<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $team = TeamMember::active()->get();
        $stats = Setting::getGroup('stats');
        $about = Setting::getGroup('about');

        return view('pages.about', compact('team', 'stats', 'about'));
    }
}
