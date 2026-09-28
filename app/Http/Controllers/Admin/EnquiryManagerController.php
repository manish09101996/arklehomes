<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\ContactEnquiry;

class EnquiryManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactEnquiry::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $enquiries = $query->latest()->paginate(15)->withQueryString();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(ContactEnquiry $enquiry)
    {
        if ($enquiry->status === 'unread') {
            $enquiry->status = 'read';
            $enquiry->save();
        }

        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, ContactEnquiry $enquiry)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $enquiry->status = $request->status;
        if ($request->has('admin_notes')) {
            $enquiry->admin_notes = $request->admin_notes;
        }
        $enquiry->save();

        return redirect()->back()->with('success', 'Enquiry status updated.');
    }

    public function destroy(ContactEnquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'arkle-homes-enquiries-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Project Type', 'Message', 'Status', 'Date Received']);

            ContactEnquiry::latest()->chunk(100, function ($enquiries) use ($handle) {
                foreach ($enquiries as $enquiry) {
                    fputcsv($handle, [
                        $enquiry->id,
                        $enquiry->name,
                        $enquiry->email,
                        $enquiry->phone,
                        $enquiry->project_type,
                        $enquiry->message,
                        $enquiry->status,
                        $enquiry->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
