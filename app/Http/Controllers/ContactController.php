<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactEnquiry;
use App\Models\Page;
use App\Models\SeoMeta;
use App\Mail\ContactEnquiryMail;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'contact')->first();

        $seo = SeoMeta::forPath('/contact') ?? (object)[
            'meta_title' => $page->seo_title ?? 'Contact Arkle Homes | Start Your Custom Home Project',
            'meta_description' => $page->seo_description ?? 'Contact Sean and the Arkle Homes team at 240 Emmersons Road Lovely Banks VIC or call 0430 331 187.',
            'meta_keywords' => $page->seo_keywords,
            'og_image' => null,
        ];

        return view('frontend.contact', compact('page', 'seo'));
    }

    public function submit(Request $request)
    {
        // Honeypot check for spam bots
        if ($request->filled('website_url')) {
            return response()->json(['success' => true, 'message' => 'Thank you for your enquiry.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:40',
            'project_type' => 'nullable|string|max:80',
            'message' => 'required|string|min:8|max:4000',
        ]);

        $enquiry = ContactEnquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'project_type' => $validated['project_type'] ?? 'General Enquiry',
            'message' => $validated['message'],
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        // Send email notification to business admin
        try {
            $adminEmail = setting('site_email', 'sean@arklehomes.com.au');
            Mail::to($adminEmail)->send(new ContactEnquiryMail($enquiry));
        } catch (\Exception $e) {
            Log::warning('Email sending failed for enquiry #' . $enquiry->id . ': ' . $e->getMessage());
        }

        $successMsg = 'Thank you! Your enquiry has been received. A member of the Arkle Homes team will contact you shortly.';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
            ]);
        }

        return redirect()->back()->with('success', $successMsg);
    }
}
