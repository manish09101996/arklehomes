<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class HeaderFooterManagerController extends Controller
{
    public function index()
    {
        return view('admin.header-footer.index');
    }

    public function update(Request $request)
    {
        $fields = [
            'header_cta_text',
            'header_cta_url',
            'site_email',
            'site_phone',
            'site_address',
            'site_abn',
            'footer_description',
            'footer_copyright',
            'facebook_url',
            'instagram_url',
            'linkedin_url',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field));
            }
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('branding', 'public');
            SiteSetting::set('site_logo', $path, 'branding', 'image');
        }

        return redirect()->route('admin.header-footer.index')->with('success', 'Header and Footer configuration saved.');
    }
}
