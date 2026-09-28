<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialManagerController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->orderBy('created_at', 'desc')->paginate(20);
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
        
        $maxOrder = Testimonial::max('order') ?? 0;
        $testimonial->order = isset($validated['order']) && $validated['order'] !== '' ? (int)$validated['order'] : ($maxOrder + 1);

        if ($request->hasFile('avatar')) {
            $testimonial->avatar = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
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
            'remove_avatar' => 'nullable|boolean',
        ]);

        $testimonial->client_name = $validated['client_name'];
        $testimonial->client_role = $validated['client_role'] ?? 'Home Owner';
        $testimonial->review = $validated['review'];
        $testimonial->rating = $validated['rating'];
        $testimonial->location = $validated['location'] ?? null;
        $testimonial->is_featured = $request->boolean('is_featured');
        $testimonial->is_published = $request->boolean('is_published');
        $testimonial->order = isset($validated['order']) && $validated['order'] !== '' ? (int)$validated['order'] : $testimonial->order;

        if ($request->boolean('remove_avatar')) {
            if ($testimonial->avatar && Storage::disk('public')->exists($testimonial->avatar)) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $testimonial->avatar = null;
        }

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && Storage::disk('public')->exists($testimonial->avatar)) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $testimonial->avatar = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function togglePublished(Testimonial $testimonial)
    {
        $testimonial->is_published = !$testimonial->is_published;
        $testimonial->save();

        $status = $testimonial->is_published ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Testimonial successfully {$status}.");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:testimonials,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Testimonial::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Orders updated successfully.']);
        }

        return redirect()->back()->with('success', 'Testimonials reordered successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar && Storage::disk('public')->exists($testimonial->avatar)) {
            Storage::disk('public')->delete($testimonial->avatar);
        }

        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
