<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Portfolio/Index', [
            'portfolios' => Portfolio::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Portfolio/Form', [
            'portfolio' => null,
            'categories' => $this->getCategories(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePortfolio($request);
        $validated['image'] = $this->handleImageUpload($request);

        Portfolio::create($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit(Portfolio $portfolio)
    {
        return Inertia::render('Admin/Portfolio/Form', [
            'portfolio' => $portfolio,
            'categories' => $this->getCategories(),
        ]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validatePortfolio($request, $portfolio->id);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleImageUpload($request);
        }

        // Re-generate slug jika title berubah dan slug tidak di-input manual
        if (empty($validated['slug']) || $validated['slug'] === $portfolio->slug) {
            if ($validated['title'] !== $portfolio->title) {
                $validated['slug'] = Str::slug($validated['title']);
            }
        }

        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio berhasil diupdate!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio berhasil dihapus!');
    }

    public function trash()
    {
        return Inertia::render('Admin/Portfolio/Trash', [
            'portfolios' => Portfolio::onlyTrashed()->orderByDesc('deleted_at')->get(),
        ]);
    }

    public function restore(int $id)
    {
        $portfolio = Portfolio::onlyTrashed()->findOrFail($id);
        $portfolio->restore();
        return redirect()->route('admin.portfolio.trash')->with('success', 'Portfolio berhasil dipulihkan!');
    }

    public function forceDelete(int $id)
    {
        $portfolio = Portfolio::onlyTrashed()->findOrFail($id);
        $portfolio->forceDelete();
        return redirect()->route('admin.portfolio.trash')->with('success', 'Portfolio berhasil dihapus permanen!');
    }

    private function validatePortfolio(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:portfolios,slug' . ($ignoreId ? ",{$ignoreId}" : ''),
            'description' => 'required|string',
            'client'      => 'required|string|max:255',
            'year'        => 'required|digits:4|integer|min:1900|max:2099',
            'category'    => 'required|string|max:100',
            'image'       => 'nullable|image|max:5120',
            'image_url'   => 'nullable|url|max:2048',
            'featured'    => 'boolean',
            'active'      => 'boolean',
            'order'       => 'integer|min:0',
        ]);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('portfolios', 'public');
        }
        return $request->input('image_url');
    }

    private function getCategories(): array
    {
        $existing = Portfolio::distinct()->pluck('category')->sort()->values()->toArray();
        $defaults = ['Web Design', 'Graphic Design', 'Photo & Video', 'Digital Marketing'];
        return array_values(array_unique(array_merge($defaults, $existing)));
    }
}
