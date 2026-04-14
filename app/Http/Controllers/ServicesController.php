<?php

namespace App\Http\Controllers;

use App\Models\ProcessStep;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::with('features')->active()->get();
        $processSteps = ProcessStep::orderBy('order')->get();

        return view('pages.services', compact('services', 'processSteps'));
    }
}
