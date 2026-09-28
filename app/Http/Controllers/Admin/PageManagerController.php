<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\PageSection;

class PageManagerController extends Controller
{
    public function index()
    {
        $pages = Page::withCount('sections')->orderBy('order')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        $page->load('sections');
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:250',
            'hero_badge' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'seo_title' => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:300',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $page->title = $validated['title'];
        $page->subtitle = $validated['subtitle'] ?? null;
        $page->hero_badge = $validated['hero_badge'] ?? null;
        $page->content = $validated['content'] ?? null;
        $page->is_published = $request->boolean('is_published', true);
        $page->seo_title = $validated['seo_title'] ?? null;
        $page->seo_description = $validated['seo_description'] ?? null;
        $page->seo_keywords = $validated['seo_keywords'] ?? null;

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('pages', 'public');
            $page->hero_image = $path;
        }

        $page->save();

        return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Page content updated successfully.');
    }

    public function addSection(Request $request, Page $page)
    {
        $validated = $request->validate([
            'section_type' => 'required|string',
            'title' => 'nullable|string|max:200',
            'subtitle' => 'nullable|string|max:250',
            'content' => 'nullable|string',
        ]);

        $order = ($page->sections()->max('order') ?? 0) + 1;

        $section = PageSection::create([
            'page_id' => $page->id,
            'section_type' => $validated['section_type'],
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'] ?? null,
            'order' => $order,
            'is_visible' => true,
        ]);

        return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Section added successfully.');
    }

    public function updateSection(Request $request, PageSection $section)
    {
        $section->title = $request->input('title');
        $section->subtitle = $request->input('subtitle');
        $section->content = $request->input('content');
        $section->badge = $request->input('badge');
        $section->button_text = $request->input('button_text');
        $section->button_url = $request->input('button_url');
        $section->is_visible = $request->boolean('is_visible', true);
        $section->order = $request->input('order', $section->order);

        if ($request->hasFile('image')) {
            $section->image = $request->file('image')->store('sections', 'public');
        }

        $section->save();

        return redirect()->route('admin.pages.edit', $section->page_id)->with('success', 'Section updated.');
    }

    public function deleteSection(PageSection $section)
    {
        $pageId = $section->page_id;
        $section->delete();
        return redirect()->route('admin.pages.edit', $pageId)->with('success', 'Section deleted.');
    }

    public function toggleSection(PageSection $section)
    {
        $section->is_visible = !$section->is_visible;
        $section->save();
        return response()->json(['success' => true, 'is_visible' => $section->is_visible]);
    }
}
