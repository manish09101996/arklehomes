<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\Page;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $projects = Project::where('is_published', true)->orderBy('updated_at', 'desc')->get();
        $pages = Page::where('is_published', true)->get();

        $content = view('frontend.seo.sitemap', compact('projects', 'pages'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /login\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
