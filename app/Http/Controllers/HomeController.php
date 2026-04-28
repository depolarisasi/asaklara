<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Client;

class HomeController extends Controller
{
    public function index()
    {
        $hero     = Setting::getGroup('hero');
        $services = Service::with('features')->active()->take(4)->get();
        $portfolios = Portfolio::active()->where('featured', true)->take(3)->get();
        if ($portfolios->count() < 3) {
            $portfolios = Portfolio::active()->take(3)->get();
        }
        $stats  = Setting::getGroup('stats');
        $about  = Setting::getGroup('about');
        $team   = TeamMember::active()->take(4)->get();
        $clients = Client::active()->get();

        return view('pages.home', compact('hero', 'services', 'portfolios', 'stats', 'about', 'team', 'clients'));
    }
}
