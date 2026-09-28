@extends('layouts.admin')

@section('title', 'Add New Project')

@section('content')

    <div class="page-header">
        <div>
            <h1>Create Project</h1>
            <p>Add a new architectural build to the Arkle Homes portfolio.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">&larr; Back to Projects</a>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            
            <!-- Left Main Column -->
            <div>
                <!-- Primary Information -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>General Information</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-form-group">
                            <label for="projectTitle" class="admin-form-label">Project Title *</label>
                            <input type="text" id="projectTitle" name="title" class="admin-form-control" placeholder="e.g. Modern Family Home" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-grid">
                            <div class="col-6 admin-form-group">
                                <label for="category_id" class="admin-form-label">Category</label>
                                <select id="category_id" name="category_id" class="admin-form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 admin-form-group">
                                <label for="projectLocation" class="admin-form-label">Location / Suburb</label>
                                <input type="text" id="projectLocation" name="location" class="admin-form-control" placeholder="e.g. Geelong, VIC" value="{{ old('location') }}">
                            </div>

                            <div class="col-6 admin-form-group">
                                <label for="projectStatus" class="admin-form-label">Status *</label>
                                <select id="projectStatus" name="status" class="admin-form-control">
                                    <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Under Construction" {{ old('status') === 'Under Construction' ? 'selected' : '' }}>Under Construction</option>
                                    <option value="Concept Design" {{ old('status') === 'Concept Design' ? 'selected' : '' }}>Concept Design</option>
                                </select>
                            </div>

                            <div class="col-6 admin-form-group">
                                <label for="projectType" class="admin-form-label">Project Type</label>
                                <input type="text" id="projectType" name="project_type" class="admin-form-control" placeholder="e.g. Custom Home, Townhouse" value="{{ old('project_type', 'Residential') }}">
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label for="short_description" class="admin-form-label">Short Description (Cards & Summaries)</label>
                            <textarea id="short_description" name="short_description" class="admin-form-control" rows="3" placeholder="Brief 1-2 sentence description...">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="admin-form-group">
                            <label for="full_description" class="admin-form-label">Full Description (Detail Page HTML)</label>
                            <textarea id="full_description" name="full_description" class="admin-form-control" rows="8" placeholder="Detailed architectural narrative, design decisions, materials and features...">{{ old('full_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- EXTERNAL PROJECT LINK / REDIRECT SETTINGS -->
                <div class="admin-card" style="border-left: 4px solid var(--admin-gold);">
                    <div class="admin-card-header" style="background-color: #FFFDF9;">
                        <h3>Project Link & Redirection Behavior</h3>
                        <span class="badge badge-gold">Dynamic Destination</span>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-grid">
                            <div class="col-6 admin-form-group">
                                <label for="projectLinkType" class="admin-form-label">Project Link Type *</label>
                                <select id="projectLinkType" name="link_type" class="admin-form-control">
                                    <option value="internal" {{ old('link_type', 'internal') === 'internal' ? 'selected' : '' }}>
                                        1. Internal Project Page (/projects/{slug})
                                    </option>
                                    <option value="external" {{ old('link_type') === 'external' ? 'selected' : '' }}>
                                        2. External Website (Redirect on Click)
                                    </option>
                                </select>
                                <small style="color: #64748B; display: block; margin-top: 4px;">
                                    Choose whether clicking project cards links to internal detail page or redirects externally.
                                </small>
                            </div>

                            <div class="col-6 admin-form-group">
                                <label class="admin-form-label">Open in New Tab?</label>
                                <div style="margin-top: 10px;">
                                    <label class="switch-label">
                                        <input type="checkbox" name="open_new_tab" value="1" class="switch-input" {{ old('open_new_tab', 1) ? 'checked' : '' }}>
                                        <span>Open target="_blank" rel="noopener noreferrer"</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 admin-form-group" id="externalUrlGroup" style="display: none;">
                                <label for="externalUrl" class="admin-form-label">External Project URL</label>
                                <input type="url" id="externalUrl" name="external_url" class="admin-form-control" placeholder="https://www.realestate.com.au/sold/property-house-vic-sunbury-142916044" value="{{ old('external_url') }}">
                                <small style="color: #64748B; display: block; margin-top: 4px;">
                                    e.g., Realestate.com.au, Domain, or project microsite. If empty, falls back to internal project page.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Architectural Specifications -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Specifications & Dimensions</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="form-grid">
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">Bedrooms</label>
                                <input type="number" name="bedrooms" class="admin-form-control" placeholder="4" value="{{ old('bedrooms') }}" min="0">
                            </div>
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">Bathrooms</label>
                                <input type="number" name="bathrooms" class="admin-form-control" placeholder="2" value="{{ old('bathrooms') }}" min="0">
                            </div>
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">Garage Spaces</label>
                                <input type="number" name="garage" class="admin-form-control" placeholder="2" value="{{ old('garage') }}" min="0">
                            </div>
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">Land Size</label>
                                <input type="text" name="land_size" class="admin-form-control" placeholder="e.g. 540 m²" value="{{ old('land_size') }}">
                            </div>
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">House Size</label>
                                <input type="text" name="house_size" class="admin-form-control" placeholder="e.g. 285 m²" value="{{ old('house_size') }}">
                            </div>
                            <div class="col-4 admin-form-group">
                                <label class="admin-form-label">Year Completed</label>
                                <input type="text" name="year" class="admin-form-control" placeholder="2025" value="{{ old('year', date('Y')) }}">
                            </div>
                        </div>

                        <!-- Custom Spec Repeater -->
                        <div style="margin-top: 16px;">
                            <label class="admin-form-label">Additional Custom Specifications</label>
                            <div id="specsContainer"></div>
                            <button type="button" id="addSpecRowBtn" class="btn-admin btn-admin-outline btn-admin-sm" style="margin-top: 8px;">
                                + Add Custom Spec Row
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Architectural Features Repeater -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Key Features & Highlights</h3>
                    </div>
                    <div class="admin-card-body">
                        <div id="featuresContainer">
                            <div class="repeater-row">
                                <input type="text" name="features[0][title]" class="admin-form-control" placeholder="Feature Highlight (e.g. Butler's Pantry & Stone Benches)">
                                <button type="button" class="repeater-remove-btn" onclick="this.parentElement.remove()">&times;</button>
                            </div>
                            <div class="repeater-row">
                                <input type="text" name="features[1][title]" class="admin-form-control" placeholder="Feature Highlight (e.g. Double-Glazed Joinery)">
                                <button type="button" class="repeater-remove-btn" onclick="this.parentElement.remove()">&times;</button>
                            </div>
                        </div>
                        <button type="button" id="addFeatRowBtn" class="btn-admin btn-admin-outline btn-admin-sm" style="margin-top: 8px;">
                            + Add Feature Highlight
                        </button>
                    </div>
                </div>

                <!-- Search Engine Optimization (SEO) -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Project SEO Metadata</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-form-group">
                            <label class="admin-form-label">SEO Meta Title</label>
                            <input type="text" name="seo_title" class="admin-form-control" placeholder="Defaults to Project Title | Arkle Homes" value="{{ old('seo_title') }}">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">SEO Meta Description</label>
                            <textarea name="seo_description" class="admin-form-control" rows="2" placeholder="Search engine description...">{{ old('seo_description') }}</textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Keywords</label>
                            <input type="text" name="seo_keywords" class="admin-form-control" placeholder="Comma separated keywords..." value="{{ old('seo_keywords') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div>
                <!-- Publishing Controls -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Visibility & Publishing</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-form-group">
                            <label class="switch-label">
                                <input type="checkbox" name="is_published" value="1" class="switch-input" {{ old('is_published', 1) ? 'checked' : '' }}>
                                <span>Published on Website</span>
                            </label>
                        </div>

                        <div class="admin-form-group">
                            <label class="switch-label">
                                <input type="checkbox" name="is_featured" value="1" class="switch-input" {{ old('is_featured') ? 'checked' : '' }}>
                                <span>Featured on Homepage</span>
                            </label>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">Display Order</label>
                            <input type="number" name="order" class="admin-form-control" value="{{ old('order', 0) }}">
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">Custom URL Slug (Optional)</label>
                            <input type="text" name="slug" class="admin-form-control" placeholder="auto-generated-from-title" value="{{ old('slug') }}">
                        </div>

                        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 20px 0;">

                        <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center; padding: 12px;">
                            Save & Publish Project &rarr;
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Featured Cover Image</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-form-group">
                            <input type="file" name="featured_image" class="admin-form-control" accept="image/*">
                            <small style="color: #64748B; display: block; margin-top: 6px;">
                                High resolution image (JPG, PNG, WebP up to 8MB). Recommended: 1200x800.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Multi-Image Gallery Upload -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3>Project Gallery Images</h3>
                    </div>
                    <div class="admin-card-body">
                        <div class="admin-form-group">
                            <input type="file" name="gallery_images[]" class="admin-form-control" accept="image/*" multiple>
                            <small style="color: #64748B; display: block; margin-top: 6px;">
                                Select multiple images to populate the interactive gallery lightbox.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
