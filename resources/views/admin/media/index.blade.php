@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')

    <div class="page-header">
        <div>
            <h1>Media Library</h1>
            <p>Upload, manage, and reuse architectural photography and site assets.</p>
        </div>
    </div>

    <!-- Upload Card -->
    <div class="admin-card" style="margin-bottom: 24px;">
        <div class="admin-card-header">
            <h3>Upload Media Files</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                @csrf
                <div style="flex-grow: 1;">
                    <input type="file" name="files[]" class="admin-form-control" accept="image/*,application/pdf" multiple required>
                </div>
                <button type="submit" class="btn-admin btn-admin-gold">
                    Upload File(s) &rarr;
                </button>
            </form>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Library Files ({{ $mediaItems->total() }})</h3>
        </div>
        <div class="admin-card-body">
            @if($mediaItems->isNotEmpty())
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 18px;">
                    @foreach($mediaItems as $media)
                        <div style="background: #FAFAFA; border: 1px solid var(--admin-border); border-radius: 6px; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="height: 120px; background: #EEE; overflow: hidden; position: relative;">
                                @if(str_starts_with($media->mime_type, 'image/'))
                                    <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #64748B;">
                                        PDF Doc
                                    </div>
                                @endif
                            </div>
                            <div style="padding: 10px; font-size: 0.78rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $media->original_name }}">
                                        {{ $media->original_name }}
                                    </div>
                                    <div style="color: #64748B; margin-top: 2px;">{{ $media->formatted_size }}</div>
                                </div>
                                <div style="display: flex; gap: 6px; margin-top: 10px;">
                                    <button type="button" class="btn-admin btn-admin-outline btn-admin-sm" style="flex-grow: 1; justify-content: center; font-size: 0.72rem;" onclick="navigator.clipboard.writeText('{{ $media->url }}'); alert('Media URL copied to clipboard!');">
                                        Copy URL
                                    </button>
                                    <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Delete media file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" style="padding: 5px 8px;">
                                            &times;
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 24px;">
                    {{ $mediaItems->links() }}
                </div>
            @else
                <p style="color: #64748B; text-align: center; padding: 40px 0;">No media files uploaded yet.</p>
            @endif
        </div>
    </div>

@endsection
