<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Team/Index', [
            'members' => TeamMember::orderBy('order')->get()->map(fn($m) => [
                ...$m->toArray(),
                'image_url' => $m->image_url,
            ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Team/Form', ['member' => null]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateMember($request);
        $validated['image'] = $this->handleImageUpload($request);

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    public function edit(TeamMember $team)
    {
        return Inertia::render('Admin/Team/Form', [
            'member' => [...$team->toArray(), 'image_url' => $team->image_url],
        ]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $this->validateMember($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload($request);
        }

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil diupdate!');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil dihapus!');
    }

    public function trash()
    {
        return Inertia::render('Admin/Team/Trash', [
            'members' => TeamMember::onlyTrashed()->orderByDesc('deleted_at')->get()->map(fn($m) => [
                ...$m->toArray(),
                'image_url' => $m->image_url,
            ]),
        ]);
    }

    public function restore(int $id)
    {
        $member = TeamMember::onlyTrashed()->findOrFail($id);
        $member->restore();
        return redirect()->route('admin.team.trash')->with('success', 'Anggota tim berhasil dipulihkan!');
    }

    public function forceDelete(int $id)
    {
        $member = TeamMember::onlyTrashed()->findOrFail($id);
        $member->forceDelete();
        return redirect()->route('admin.team.trash')->with('success', 'Anggota tim berhasil dihapus permanen!');
    }

    private function validateMember(Request $request): array
    {
        return $request->validate([
            'name'      => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'order'     => 'integer|min:0',
            'active'    => 'boolean',
        ]);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('team', 'public');
        }
        return $request->input('image_url');
    }
}
