<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::with('features')->orderBy('order')->get()->map(fn($s) => [
                ...$s->toArray(),
                'image_url' => $s->image_url,
            ]),
            'process_steps' => ProcessStep::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Services/Form', ['service' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:5120',
            'image_url'   => 'nullable|url|max:2048',
            'order'       => 'integer|min:0',
            'active'      => 'boolean',
            'features'    => 'array',
            'features.*'  => 'string|max:255',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('services', 'public')
            : $request->input('image_url');

        $service = Service::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'image'       => $imagePath,
            'order'       => $validated['order'] ?? 0,
            'active'      => $validated['active'] ?? true,
        ]);

        foreach ($validated['features'] ?? [] as $i => $feature) {
            if (trim($feature)) {
                ServiceFeature::create(['service_id' => $service->id, 'feature' => $feature, 'order' => $i]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Admin/Services/Form', [
            'service' => [...$service->load('features')->toArray(), 'image_url' => $service->image_url],
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:5120',
            'image_url'   => 'nullable|url|max:2048',
            'order'       => 'integer|min:0',
            'active'      => 'boolean',
            'features'    => 'array',
            'features.*'  => 'string|max:255',
        ]);

        $data = [
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'order'       => $validated['order'] ?? $service->order,
            'active'      => $validated['active'] ?? $service->active,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        $service->features()->delete();
        foreach ($validated['features'] ?? [] as $i => $feature) {
            if (trim($feature)) {
                ServiceFeature::create(['service_id' => $service->id, 'feature' => $feature, 'order' => $i]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }

    public function trash()
    {
        return Inertia::render('Admin/Services/Trash', [
            'services' => Service::onlyTrashed()->orderByDesc('deleted_at')->get()->map(fn($s) => [
                ...$s->toArray(),
                'image_url' => $s->image_url,
            ]),
        ]);
    }

    public function restore(int $id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();
        return redirect()->route('admin.services.trash')->with('success', 'Layanan berhasil dipulihkan!');
    }

    public function forceDelete(int $id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->forceDelete();
        return redirect()->route('admin.services.trash')->with('success', 'Layanan berhasil dihapus permanen!');
    }

    public function storeProcessStep(Request $request)
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:5',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'order'       => 'integer|min:0',
        ]);
        ProcessStep::create($validated);
        return back()->with('success', 'Process step berhasil ditambahkan!');
    }

    public function updateProcessStep(Request $request, ProcessStep $processStep)
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:5',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'order'       => 'integer|min:0',
        ]);
        $processStep->update($validated);
        return back()->with('success', 'Process step berhasil diupdate!');
    }

    public function destroyProcessStep(ProcessStep $processStep)
    {
        $processStep->delete();
        return back()->with('success', 'Process step berhasil dihapus!');
    }
}
