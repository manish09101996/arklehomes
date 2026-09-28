@extends('layouts.admin')

@section('title', 'Edit Page: ' . $page->title)

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Page: {{ $page->title }}</h1>
            <p>Customize page metadata, hero banner, and dynamic layout sections.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/' . ($page->slug === 'home' ? '' : $page->slug)) }}" target="_blank" class="btn-admin btn-admin-outline">
                View Live Page ↗
            </a>
            <a href="{{ route('admin.pages.index') }}" class="btn-admin btn-admin-outline">&larr; Back to Pages</a>
        </div>
    </div>

    <!-- Main Page Settings Form -->
    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Page Details & Hero Banner</h3>
                <button type="submit" class="btn-admin btn-admin-gold btn-admin-sm">Save Page Changes</button>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Page Title *</label>
                        <input type="text" name="title" class="admin-form-control" value="{{ old('title', $page->title) }}" required>
                    </div>

                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Hero Eyebrow / Badge Text</label>
                        <input type="text" name="hero_badge" class="admin-form-control" value="{{ old('hero_badge', $page->hero_badge) }}">
                    </div>

                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Subtitle / Tagline</label>
                        <input type="text" name="subtitle" class="admin-form-control" value="{{ old('subtitle', $page->subtitle) }}">
                    </div>

                    @if(in_array($page->slug, ['about', 'design', 'privacy-policy', 'terms-and-conditions']))
                        <div class="col-12 admin-form-group">
                            <label class="admin-form-label">Page Main Content (Rich Text / HTML)</label>
                            <textarea name="content" class="admin-form-control" rows="10">{{ old('content', $page->content) }}</textarea>
                        </div>
                    @endif

                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Hero Background Image</label>
                        <input type="file" name="hero_image" class="admin-form-control" accept="image/*">
                        @if($page->hero_image)
                            <small style="color: #64748B;">Current: {{ $page->hero_image }}</small>
                        @endif
                    </div>

                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Status</label>
                        <div style="margin-top: 8px;">
                            <label class="switch-label">
                                <input type="checkbox" name="is_published" value="1" class="switch-input" {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                                <span>Published</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">SEO Title</label>
                        <input type="text" name="seo_title" class="admin-form-control" value="{{ old('seo_title', $page->seo_title) }}">
                    </div>
                    <div class="col-8 admin-form-group">
                        <label class="admin-form-label">SEO Meta Description</label>
                        <input type="text" name="seo_description" class="admin-form-control" value="{{ old('seo_description', $page->seo_description) }}">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Page Builder: Modular Sections System -->
    <div class="page-header" style="margin-top: 40px;">
        <div>
            <h2>Page Builder Sections ({{ $page->sections->count() }})</h2>
            <p>Add, edit, reorder or toggle visibility of modular sections on this page.</p>
        </div>
    </div>

    <!-- Existing Sections List -->
    @foreach($page->sections as $sec)
        <div class="admin-card" style="margin-bottom: 18px; border-left: 4px solid var(--admin-sidebar-bg);">
            <div class="admin-card-header" style="background-color: #F8FAFC;">
                <div>
                    <span class="badge badge-info" style="margin-right: 8px;">{{ strtoupper($sec->section_type) }}</span>
                    <strong style="color: var(--admin-sidebar-bg);">{{ $sec->title ?: 'Untitled Section' }}</strong>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <form action="{{ route('admin.pages.sections.delete', $sec->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                    </form>
                </div>
            </div>

            <div class="admin-card-body">
                <form action="{{ route('admin.pages.sections.update', $sec->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Section Title</label>
                            <input type="text" name="title" class="admin-form-control" value="{{ $sec->title }}">
                        </div>
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Section Eyebrow Badge</label>
                            <input type="text" name="badge" class="admin-form-control" value="{{ $sec->badge }}">
                        </div>
                        <div class="col-12 admin-form-group">
                            <label class="admin-form-label">Section Subtitle / Description</label>
                            <textarea name="content" class="admin-form-control" rows="3">{{ $sec->content }}</textarea>
                        </div>
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Button Text</label>
                            <input type="text" name="button_text" class="admin-form-control" value="{{ $sec->button_text }}">
                        </div>
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Button URL</label>
                            <input type="text" name="button_url" class="admin-form-control" value="{{ $sec->button_url }}">
                        </div>
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Order</label>
                            <input type="number" name="order" class="admin-form-control" value="{{ $sec->order }}">
                        </div>
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Replace Section Image</label>
                            <input type="file" name="image" class="admin-form-control" accept="image/*">
                            @if($sec->image)
                                <small style="color: #64748B;">Current image: {{ $sec->image }}</small>
                            @endif
                        </div>
                        <div class="col-6 admin-form-group" style="display: flex; align-items: flex-end; justify-content: flex-end; gap: 14px;">
                            <label class="switch-label">
                                <input type="checkbox" name="is_visible" value="1" class="switch-input" {{ $sec->is_visible ? 'checked' : '' }}>
                                <span>Visible on Website</span>
                            </label>
                            <button type="submit" class="btn-admin btn-admin-gold btn-admin-sm">Update Section</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Add Section Card -->
    <div class="admin-card" style="border: 2px dashed #CBD5E1; background: #FAFAFA;">
        <div class="admin-card-header">
            <h3>+ Add New Section to {{ $page->title }}</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.pages.sections.add', $page->id) }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Section Type *</label>
                        <select name="section_type" class="admin-form-control" required>
                            <option value="text">Text Section</option>
                            <option value="image_text">Image + Text (Two Column)</option>
                            <option value="gallery">Image Gallery</option>
                            <option value="features">Feature Highlights</option>
                            <option value="projects">Projects Showcase</option>
                            <option value="testimonials">Testimonials Slider/Grid</option>
                            <option value="statistics">Statistics Counters</option>
                            <option value="cta">Call to Action Banner</option>
                            <option value="faq">FAQ Accordion</option>
                            <option value="custom_html">Custom HTML / Embed</option>
                        </select>
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Section Title</label>
                        <input type="text" name="title" class="admin-form-control" placeholder="e.g. Masterful Joinery">
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Subtitle</label>
                        <input type="text" name="subtitle" class="admin-form-control" placeholder="Brief supporting copy...">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Content</label>
                        <textarea name="content" class="admin-form-control" rows="3" placeholder="Section body text..."></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-admin btn-admin-primary">
                            + Add Section &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
