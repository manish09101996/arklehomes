<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Page;
use App\Models\SeoMeta;

class ProjectController extends Controller
{
    /**
     * Display projects listing with filtering, sorting, and AJAX support.
     */
    public function index(Request $request)
    {
        $page = Page::where('slug', 'projects')->first();
        $categories = ProjectCategory::where('is_active', true)->orderBy('order')->get();

        $query = Project::with('category')->where('is_published', true);

        // Filter by category slug
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'a-z':
                $query->orderBy('title', 'asc');
                break;
            case 'z-a':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
                break;
        }

        $projects = $query->paginate(9)->withQueryString();

        // If AJAX request, return project cards partial
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.project-cards', compact('projects'))->render(),
                'pagination' => view('frontend.partials.pagination', ['paginator' => $projects])->render(),
                'count' => $projects->total(),
            ]);
        }

        $seo = SeoMeta::forPath('/projects') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Completed Projects Portfolio | Arkle Homes',
            'meta_description' => $page->seo_description ?? 'Browse our luxury residential projects and custom built homes across Victoria.',
            'meta_keywords' => $page->seo_keywords ?? 'arkle homes portfolio, custom homes, townhouses',
            'og_image' => null,
        ];

        return view('frontend.projects.index', compact('page', 'categories', 'projects', 'seo', 'sort'));
    }

    /**
     * Display single project detail page.
     */
    public function show(string $slug)
    {
        $project = Project::with(['category', 'images', 'features', 'specifications'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // If configured as external redirect and accessed directly
        if ($project->is_external && request()->has('redirect')) {
            return redirect()->away($project->external_url);
        }

        // Related projects in same category
        $relatedProjects = Project::where('is_published', true)
            ->where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->orderBy('order')
            ->take(3)
            ->get();

        // Fallback related if none in same category
        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('is_published', true)
                ->where('id', '!=', $project->id)
                ->orderBy('order')
                ->take(3)
                ->get();
        }

        // Previous and Next project
        $prevProject = Project::where('is_published', true)
            ->where('id', '<', $project->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextProject = Project::where('is_published', true)
            ->where('id', '>', $project->id)
            ->orderBy('id', 'asc')
            ->first();

        $seo = (object)[
            'meta_title' => $project->seo_title ?: ($project->title . ' | Arkle Homes'),
            'meta_description' => $project->seo_description ?: $project->short_description,
            'meta_keywords' => $project->seo_keywords,
            'og_image' => $project->featured_image_url,
        ];

        return view('frontend.projects.show', compact('project', 'relatedProjects', 'prevProject', 'nextProject', 'seo'));
    }
}
