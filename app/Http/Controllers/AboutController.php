<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Client;

class AboutController extends Controller
{
    public function index()
    {
        $team = TeamMember::active()->get();
        $stats = Setting::getGroup('stats');
        $about = Setting::getGroup('about');
        $clients = Client::active()->get();

        return view('pages.about', compact('team', 'stats', 'about', 'clients'));
    }
}
