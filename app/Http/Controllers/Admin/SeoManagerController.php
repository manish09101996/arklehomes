<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoMeta;

class SeoManagerController extends Controller
{
    public function index()
    {
        $seoList = SeoMeta::all();
        return view('admin.seo.index', compact('seoList'));
    }

    public function update(Request $request, SeoMeta $seo)
    {
        $validated = $request->validate([
            'meta_title' => 'required|string|max:200',
            'meta_description' => 'required|string|max:500',
            'meta_keywords' => 'nullable|string|max:300',
            'canonical_url' => 'nullable|url|max:255',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $seo->meta_title = $validated['meta_title'];
        $seo->meta_description = $validated['meta_description'];
        $seo->meta_keywords = $validated['meta_keywords'] ?? null;
        $seo->canonical_url = $validated['canonical_url'] ?? null;

        if ($request->hasFile('og_image')) {
            $seo->og_image = $request->file('og_image')->store('seo', 'public');
        }

        $seo->save();

        return redirect()->route('admin.seo.index')->with('success', 'SEO settings updated for ' . $seo->url_path);
    }
}
