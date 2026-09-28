<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Service;

class ServiceManagerController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:services,slug',
            'description' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['title']);

        Service::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'icon' => $validated['icon'] ?? 'home',
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Feature service created.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:services,slug,' . $service->id,
            'description' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $service->title = $validated['title'];
        if ($validated['slug']) {
            $service->slug = Str::slug($validated['slug']);
        }
        $service->description = $validated['description'];
        $service->icon = $validated['icon'] ?? 'home';
        $service->order = $validated['order'] ?? 0;
        $service->is_active = $request->boolean('is_active', true);
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Feature service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
