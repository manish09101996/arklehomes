<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuManagerController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['items' => function ($q) {
            $q->orderBy('order');
        }])->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'target' => 'required|in:_self,_blank',
            'order' => 'nullable|integer',
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'label' => $validated['label'],
            'url' => $validated['url'],
            'target' => $validated['target'],
            'order' => $validated['order'] ?? (($menu->items()->max('order') ?? 0) + 1),
            'is_active' => true,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu item added.');
    }

    public function updateItem(Request $request, MenuItem $item)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'target' => 'required|in:_self,_blank',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $item->update([
            'label' => $validated['label'],
            'url' => $validated['url'],
            'target' => $validated['target'],
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu item updated.');
    }

    public function deleteItem(MenuItem $item)
    {
        $item->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu item removed.');
    }
}
