<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use App\Models\ProjectFeature;
use App\Models\ProjectSpecification;
use App\Helpers\StorageHelper;

class ProjectManagerController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProjectCategory::orderBy('name')->get();
        $query = Project::with('category')->withCount('images');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('location', 'like', "%{$s}%");
            });
        }

        $projects = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create()
    {
        $categories = ProjectCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:projects,slug',
            'category_id' => 'nullable|exists:project_categories,id',
            'location' => 'nullable|string|max:150',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
            'status' => 'required|string',
            'completion_date' => 'nullable|date',
            'client_name' => 'nullable|string|max:120',
            'project_type' => 'nullable|string|max:100',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'land_size' => 'nullable|string|max:60',
            'house_size' => 'nullable|string|max:60',
            'year' => 'nullable|string|max:20',
            'link_type' => 'required|in:internal,external',
            'external_url' => 'nullable|url|max:1000',
            'open_new_tab' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'seo_title' => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:300',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['title']);
        $uniqueSlug = $slug;
        $counter = 1;
        while (Project::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter++;
        }

        $project = new Project();
        $project->title = $validated['title'];
        $project->slug = $uniqueSlug;
        $project->category_id = $validated['category_id'] ?? null;
        $project->location = $validated['location'] ?? null;
        $project->short_description = $validated['short_description'] ?? null;
        $project->full_description = $validated['full_description'] ?? null;
        $project->status = $validated['status'];
        $project->completion_date = $validated['completion_date'] ?? null;
        $project->client_name = $validated['client_name'] ?? null;
        $project->project_type = $validated['project_type'] ?? null;
        $project->bedrooms = $validated['bedrooms'] ?? null;
        $project->bathrooms = $validated['bathrooms'] ?? null;
        $project->garage = $validated['garage'] ?? null;
        $project->land_size = $validated['land_size'] ?? null;
        $project->house_size = $validated['house_size'] ?? null;
        $project->year = $validated['year'] ?? null;
        $project->link_type = $validated['link_type'];
        $project->external_url = $validated['external_url'] ?? null;
        $project->open_new_tab = $request->boolean('open_new_tab', true);
        $project->is_featured = $request->boolean('is_featured');
        $project->is_published = $request->boolean('is_published', true);
        $project->order = $validated['order'] ?? 0;
        $project->seo_title = $validated['seo_title'] ?? null;
        $project->seo_description = $validated['seo_description'] ?? null;
        $project->seo_keywords = $validated['seo_keywords'] ?? null;

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('projects', 'public');
            StorageHelper::sync($path);
            $project->featured_image = $path;
        }

        $project->save();

        // Process specifications
        if ($request->filled('specs')) {
            foreach ($request->input('specs') as $orderIdx => $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {
                    ProjectSpecification::create([
                        'project_id' => $project->id,
                        'spec_name' => $spec['name'],
                        'spec_value' => $spec['value'],
                        'order' => $orderIdx + 1,
                    ]);
                }
            }
        }

        // Process features
        if ($request->filled('features')) {
            foreach ($request->input('features') as $orderIdx => $feat) {
                if (!empty($feat['title'])) {
                    ProjectFeature::create([
                        'project_id' => $project->id,
                        'title' => $feat['title'],
                        'description' => $feat['description'] ?? null,
                        'order' => $orderIdx + 1,
                    ]);
                }
            }
        }

        // Process Gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $imgFile) {
                $path = $imgFile->store('projects', 'public');
                StorageHelper::sync($path);
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'caption' => $project->title . ' gallery image',
                    'alt_text' => $project->title,
                    'order' => $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', "Project '{$project->title}' created successfully.");
    }

    public function edit(Project $project)
    {
        $categories = ProjectCategory::where('is_active', true)->orderBy('name')->get();
        $project->load(['images', 'features', 'specifications']);

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:projects,slug,' . $project->id,
            'category_id' => 'nullable|exists:project_categories,id',
            'location' => 'nullable|string|max:150',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
            'status' => 'required|string',
            'completion_date' => 'nullable|date',
            'client_name' => 'nullable|string|max:120',
            'project_type' => 'nullable|string|max:100',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'land_size' => 'nullable|string|max:60',
            'house_size' => 'nullable|string|max:60',
            'year' => 'nullable|string|max:20',
            'link_type' => 'required|in:internal,external',
            'external_url' => 'nullable|url|max:1000',
            'open_new_tab' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'seo_title' => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:300',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $project->title = $validated['title'];
        if ($validated['slug'] && $validated['slug'] !== $project->slug) {
            $project->slug = Str::slug($validated['slug']);
        }
        $project->category_id = $validated['category_id'] ?? null;
        $project->location = $validated['location'] ?? null;
        $project->short_description = $validated['short_description'] ?? null;
        $project->full_description = $validated['full_description'] ?? null;
        $project->status = $validated['status'];
        $project->completion_date = $validated['completion_date'] ?? null;
        $project->client_name = $validated['client_name'] ?? null;
        $project->project_type = $validated['project_type'] ?? null;
        $project->bedrooms = $validated['bedrooms'] ?? null;
        $project->bathrooms = $validated['bathrooms'] ?? null;
        $project->garage = $validated['garage'] ?? null;
        $project->land_size = $validated['land_size'] ?? null;
        $project->house_size = $validated['house_size'] ?? null;
        $project->year = $validated['year'] ?? null;
        $project->link_type = $validated['link_type'];
        $project->external_url = $validated['external_url'] ?? null;
        $project->open_new_tab = $request->boolean('open_new_tab', true);
        $project->is_featured = $request->boolean('is_featured');
        $project->is_published = $request->boolean('is_published', true);
        $project->order = $validated['order'] ?? $project->order;
        $project->seo_title = $validated['seo_title'] ?? null;
        $project->seo_description = $validated['seo_description'] ?? null;
        $project->seo_keywords = $validated['seo_keywords'] ?? null;

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('projects', 'public');
            StorageHelper::sync($path);
            $project->featured_image = $path;
        }

        $project->save();

        // Sync Specifications
        $project->specifications()->delete();
        if ($request->filled('specs')) {
            foreach ($request->input('specs') as $orderIdx => $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {
                    ProjectSpecification::create([
                        'project_id' => $project->id,
                        'spec_name' => $spec['name'],
                        'spec_value' => $spec['value'],
                        'order' => $orderIdx + 1,
                    ]);
                }
            }
        }

        // Sync Features
        $project->features()->delete();
        if ($request->filled('features')) {
            foreach ($request->input('features') as $orderIdx => $feat) {
                if (!empty($feat['title'])) {
                    ProjectFeature::create([
                        'project_id' => $project->id,
                        'title' => $feat['title'],
                        'description' => $feat['description'] ?? null,
                        'order' => $orderIdx + 1,
                    ]);
                }
            }
        }

        // Upload additional gallery images
        if ($request->hasFile('gallery_images')) {
            $currentMaxOrder = $project->images()->max('order') ?? 0;
            foreach ($request->file('gallery_images') as $idx => $imgFile) {
                $path = $imgFile->store('projects', 'public');
                StorageHelper::sync($path);
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'caption' => $project->title . ' gallery image',
                    'alt_text' => $project->title,
                    'order' => $currentMaxOrder + $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', "Project '{$project->title}' updated successfully.");
    }

    public function destroy(Project $project)
    {
        $title = $project->title;
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', "Project '{$title}' deleted.");
    }

    public function duplicate(Project $project)
    {
        $clone = $project->replicate();
        $clone->title = $project->title . ' (Copy)';
        $clone->slug = Str::slug($clone->title . '-' . time());
        $clone->is_published = false;
        $clone->save();

        // Copy relations
        foreach ($project->specifications as $spec) {
            $cloneSpec = $spec->replicate();
            $cloneSpec->project_id = $clone->id;
            $cloneSpec->save();
        }

        foreach ($project->features as $feat) {
            $cloneFeat = $feat->replicate();
            $cloneFeat->project_id = $clone->id;
            $cloneFeat->save();
        }

        foreach ($project->images as $img) {
            $cloneImg = $img->replicate();
            $cloneImg->project_id = $clone->id;
            $cloneImg->save();
        }

        return redirect()->route('admin.projects.edit', $clone->id)->with('success', 'Project duplicated as draft.');
    }

    public function toggleFeatured(Project $project)
    {
        $project->is_featured = !$project->is_featured;
        $project->save();

        return response()->json([
            'success' => true,
            'is_featured' => $project->is_featured,
            'message' => 'Featured status updated.',
        ]);
    }

    public function togglePublished(Project $project)
    {
        $project->is_published = !$project->is_published;
        $project->save();

        return response()->json([
            'success' => true,
            'is_published' => $project->is_published,
            'message' => 'Publish status updated.',
        ]);
    }

    public function deleteImage(ProjectImage $image)
    {
        $image->delete();
        return response()->json(['success' => true]);
    }
}
