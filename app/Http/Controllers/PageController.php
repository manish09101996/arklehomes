<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\SeoMeta;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about')->firstOrFail();
        $services = Service::where('is_active', true)->orderBy('order')->get();
        $statistics = Statistic::where('is_active', true)->orderBy('order')->get();

        $seo = SeoMeta::forPath('/about') ?? (object)[
            'meta_title' => $page->seo_title ?? 'About Arkle Homes | Craftsmanship & Integrity',
            'meta_description' => $page->seo_description ?? 'Learn about Arkle Homes, our design philosophy and standard of excellence.',
            'meta_keywords' => $page->seo_keywords,
            'og_image' => null,
        ];

        return view('frontend.about', compact('page', 'services', 'statistics', 'seo'));
    }

    public function design()
    {
        $page = Page::where('slug', 'design')->firstOrFail();
        $services = Service::where('is_active', true)->orderBy('order')->get();

        $seo = SeoMeta::forPath('/design') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Design Philosophy | Arkle Homes Architectural Standards',
            'meta_description' => $page->seo_description ?? 'Bespoke design, sustainable materiality, and passive solar architectural principles.',
            'meta_keywords' => $page->seo_keywords,
            'og_image' => null,
        ];

        return view('frontend.design', compact('page', 'services', 'seo'));
    }

    public function testimonials()
    {
        $page = Page::where('slug', 'testimonials')->firstOrFail();
        $testimonials = Testimonial::where('is_published', true)->orderBy('order')->paginate(9);

        $seo = SeoMeta::forPath('/testimonials') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Client Reviews & Testimonials | Arkle Homes',
            'meta_description' => $page->seo_description ?? 'Read what our clients say about their building experience with Arkle Homes.',
            'meta_keywords' => $page->seo_keywords,
            'og_image' => null,
        ];

        return view('frontend.testimonials', compact('page', 'testimonials', 'seo'));
    }

    public function faq()
    {
        $page = Page::where('slug', 'faq')->firstOrFail();
        $faqs = Faq::where('is_published', true)->orderBy('order')->get()->groupBy('category');

        $seo = SeoMeta::forPath('/faq') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Frequently Asked Questions | Arkle Homes',
            'meta_description' => $page->seo_description ?? 'Answers to common questions regarding timelines, contracts, permits and architectural design.',
            'meta_keywords' => $page->seo_keywords,
            'og_image' => null,
        ];

        return view('frontend.faq', compact('page', 'faqs', 'seo'));
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy-policy')->firstOrFail();

        $seo = SeoMeta::forPath('/privacy-policy') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Privacy Policy | Arkle Homes',
            'meta_description' => $page->seo_description ?? 'Australian Privacy Principles and compliance for Arkle Homes.',
            'meta_keywords' => null,
            'og_image' => null,
        ];

        return view('frontend.legal', compact('page', 'seo'));
    }

    public function terms()
    {
        $page = Page::where('slug', 'terms-and-conditions')->firstOrFail();

        $seo = SeoMeta::forPath('/terms-and-conditions') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Terms & Conditions | Arkle Homes',
            'meta_description' => $page->seo_description ?? 'Website terms and conditions of use for Arkle Homes.',
            'meta_keywords' => null,
            'og_image' => null,
        ];

        return view('frontend.legal', compact('page', 'seo'));
    }
}
