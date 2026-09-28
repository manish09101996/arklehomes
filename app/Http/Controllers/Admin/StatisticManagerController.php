<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistic;

class StatisticManagerController extends Controller
{
    public function index()
    {
        $statistics = Statistic::orderBy('order')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'label' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:250',
            'order' => 'nullable|integer',
        ]);

        Statistic::create([
            'number' => $validated['number'],
            'label' => $validated['label'],
            'icon' => $validated['icon'] ?? 'home',
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic added.');
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'label' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:250',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $statistic->number = $validated['number'];
        $statistic->label = $validated['label'];
        $statistic->icon = $validated['icon'] ?? 'home';
        $statistic->description = $validated['description'] ?? null;
        $statistic->order = $validated['order'] ?? 0;
        $statistic->is_active = $request->boolean('is_active', true);
        $statistic->save();

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic updated.');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.statistics.index')->with('success', 'Statistic deleted.');
    }
}
