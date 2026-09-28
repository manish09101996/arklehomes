<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use App\Helpers\StorageHelper;

class MediaManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('original_name', 'like', "%{$s}%")
                  ->orWhere('alt_text', 'like', "%{$s}%");
        }

        $mediaItems = $query->latest()->paginate(24)->withQueryString();

        return view('admin.media.index', compact('mediaItems'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
        ]);

        $uploaded = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('media', 'public');
                StorageHelper::sync($path);

                $media = Media::create([
                    'filename' => basename($path),
                    'disk' => 'public',
                    'path' => $path,
                    'original_name' => $originalName,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'alt_text' => pathinfo($originalName, PATHINFO_FILENAME),
                ]);

                $uploaded[] = $media;
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'media' => $uploaded]);
        }

        return redirect()->route('admin.media.index')->with('success', count($uploaded) . ' file(s) uploaded successfully.');
    }

    public function destroy(Media $media)
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media file deleted.');
    }
}
