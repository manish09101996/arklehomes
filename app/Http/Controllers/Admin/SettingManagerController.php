<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingManagerController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'site_logo', 'hero_bg_image', 'about_image', 'commitment_bg']);

        foreach ($inputs as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Handle image uploads
        $imageFields = ['site_logo', 'hero_bg_image', 'about_image', 'commitment_bg'];
        foreach ($imageFields as $imgField) {
            if ($request->hasFile($imgField)) {
                $path = $request->file($imgField)->store('settings', 'public');
                SiteSetting::set($imgField, $path, 'branding', 'image');
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully.');
    }
}
