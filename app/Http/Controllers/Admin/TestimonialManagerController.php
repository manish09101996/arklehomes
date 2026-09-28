<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialManagerController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:100',
            'client_role' => 'nullable|string|max:100',
            'review' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'location' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $testimonial = new Testimonial();
        $testimonial->client_name = $validated['client_name'];
        $testimonial->client_role = $validated['client_role'] ?? 'Home Owner';
        $testimonial->review = $validated['review'];
        $testimonial->rating = $validated['rating'];
        $testimonial->location = $validated['location'] ?? null;
        $testimonial->is_featured = $request->boolean('is_featured', true);
        $testimonial->is_published = $request->boolean('is_published', true);
        $testimonial->order = $validated['order'] ?? 0;

        if ($request->hasFile('avatar')) {
            $testimonial->avatar = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:100',
            'client_role' => 'nullable|string|max:100',
            'review' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'location' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $testimonial->client_name = $validated['client_name'];
        $testimonial->client_role = $validated['client_role'] ?? 'Home Owner';
        $testimonial->review = $validated['review'];
        $testimonial->rating = $validated['rating'];
        $testimonial->location = $validated['location'] ?? null;
        $testimonial->is_featured = $request->boolean('is_featured');
        $testimonial->is_published = $request->boolean('is_published');
        $testimonial->order = $validated['order'] ?? 0;

        if ($request->hasFile('avatar')) {
            $testimonial->avatar = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }
}
