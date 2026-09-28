<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProjectCategory;

class CategoryManagerController extends Controller
{
    public function index()
    {
        $categories = ProjectCategory::withCount('projects')->orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:project_categories,slug',
            'description' => 'nullable|string|max:300',
            'order' => 'nullable|integer',
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);

        ProjectCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, ProjectCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:project_categories,slug,' . $category->id,
            'description' => 'nullable|string|max:300',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category->name = $validated['name'];
        if ($validated['slug']) {
            $category->slug = Str::slug($validated['slug']);
        }
        $category->description = $validated['description'] ?? null;
        $category->order = $validated['order'] ?? 0;
        $category->is_active = $request->boolean('is_active', true);
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ProjectCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category removed.');
    }
}
