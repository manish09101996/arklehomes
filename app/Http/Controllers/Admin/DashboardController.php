<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Testimonial;
use App\Models\ContactEnquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $publishedProjects = Project::where('is_published', true)->count();
        $draftProjects = Project::where('is_published', false)->count();
        $totalTestimonials = Testimonial::count();
        $totalEnquiries = ContactEnquiry::count();
        $unreadEnquiries = ContactEnquiry::where('status', 'unread')->count();
        $totalCategories = ProjectCategory::count();

        $recentProjects = Project::with('category')->latest()->take(5)->get();
        $recentEnquiries = ContactEnquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'publishedProjects',
            'draftProjects',
            'totalTestimonials',
            'totalEnquiries',
            'unreadEnquiries',
            'totalCategories',
            'recentProjects',
            'recentEnquiries'
        ));
    }
}
