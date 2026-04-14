<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamMember;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'portfolios'   => Portfolio::count(),
                'services'     => Service::count(),
                'team_members' => TeamMember::count(),
                'submissions'  => ContactSubmission::count(),
                'unread'       => ContactSubmission::unread()->count(),
            ],
            'recent_submissions' => ContactSubmission::latest()->take(5)->get(),
        ]);
    }
}
