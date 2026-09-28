<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\SeoMeta;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'home')->first();

        // 4 Feature service cards
        $services = Service::where('is_active', true)->orderBy('order')->get();

        // Featured projects for homepage matching screenshot (3 items)
        $featuredProjects = Project::with('category')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        // Commitment statistics counters
        $statistics = Statistic::where('is_active', true)->orderBy('order')->get();

        // Testimonials
        $testimonials = Testimonial::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        // SEO meta
        $seo = SeoMeta::forPath('/') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Arkle Homes | Designed for Living. Built for Life.',
            'meta_description' => $page->seo_description ?? 'Bespoke modern home builder in Victoria. Custom homes, townhouses, and renovations.',
            'meta_keywords' => $page->seo_keywords ?? 'arkle homes, custom builders, luxury homes',
            'og_image' => null,
        ];

        return view('frontend.home', compact(
            'page',
            'services',
            'featuredProjects',
            'statistics',
            'testimonials',
            'seo'
        ));
    }
}
