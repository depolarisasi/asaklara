<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Clients/Index', [
            'clients' => Client::orderBy('sort_order')->get()->map(fn($c) => [
                ...$c->toArray(),
                'logo_url' => $c->logo_url,
            ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Clients/Form', ['client' => null]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateClient($request);
        $validated['image_url'] = $this->handleImageUpload($request);

        Client::create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Client berhasil ditambahkan!');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Admin/Clients/Form', [
            'client' => [...$client->toArray(), 'logo_url' => $client->logo_url],
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $this->validateClient($request);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $this->handleImageUpload($request);
        }

        $client->update($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Client berhasil diupdate!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Client berhasil dihapus!');
    }

    public function trash()
    {
        return Inertia::render('Admin/Clients/Trash', [
            'clients' => Client::onlyTrashed()->orderByDesc('deleted_at')->get()->map(fn($c) => [
                ...$c->toArray(),
                'logo_url' => $c->logo_url,
            ]),
        ]);
    }

    public function restore(int $id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->restore();
        return redirect()->route('admin.clients.trash')->with('success', 'Client berhasil dipulihkan!');
    }

    public function forceDelete(int $id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->forceDelete();
        return redirect()->route('admin.clients.trash')->with('success', 'Client berhasil dihapus permanen!');
    }

    private function validateClient(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|string|max:255',
            'image'      => 'nullable|image|max:2048',
            'image_url'  => 'nullable|url|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('clients', 'public');
        }
        return $request->input('image_url');
    }
}
