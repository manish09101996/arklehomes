@extends('layouts.admin')

@section('title', 'Edit Testimonial - ' . $testimonial->client_name)

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Testimonial</h1>
            <p>Update customer feedback, rating, avatar image, and publishing status.</p>
        </div>
        <div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin btn-admin-outline">
                &larr; Back to Testimonials
            </a>
        </div>
    </div>

    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
        <div class="admin-card-header">
            <h3>Edit Review for {{ $testimonial->client_name }}</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Name *</label>
                        <input type="text" name="client_name" class="admin-form-control" value="{{ old('client_name', $testimonial->client_name) }}" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Subtitle / Role</label>
                        <input type="text" name="client_role" class="admin-form-control" value="{{ old('client_role', $testimonial->client_role) }}" placeholder="e.g. Home Owner">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Rating (Stars) *</label>
                        <select name="rating" class="admin-form-control" required>
                            <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>★★★★★ (5 Stars)</option>
                            <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>★★★★☆ (4 Stars)</option>
                            <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>★★★☆☆ (3 Stars)</option>
                            <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Stars)</option>
                            <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Location (Optional)</label>
                        <input type="text" name="location" class="admin-form-control" value="{{ old('location', $testimonial->location) }}" placeholder="e.g. Geelong, VIC">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" value="{{ old('order', $testimonial->order) }}">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Review / Quote *</label>
                    <textarea name="review" class="admin-form-control" rows="5" required>{{ old('review', $testimonial->review) }}</textarea>
                </div>

                <!-- Avatar / Customer Image -->
                <div class="admin-form-group">
                    <label class="admin-form-label">Customer Image (Optional)</label>
                    
                    @if($testimonial->avatar)
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; background: #F8FAFC; padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border);">
                            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->client_name }}" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid var(--admin-gold);">
                            <div>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #DC2626; cursor: pointer;">
                                    <input type="checkbox" name="remove_avatar" value="1">
                                    <span>Remove current customer image</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="avatar" class="admin-form-control" accept="image/*">
                    <small style="color: #64748B; font-size: 0.8rem; margin-top: 4px; display: block;">
                        Supported formats: JPG, PNG, WEBP (Max 4MB). Square portrait recommended.
                    </small>
                </div>

                <div style="display: flex; gap: 30px; margin-top: 15px; margin-bottom: 25px; padding: 15px; background: #F8FAFC; border-radius: 6px; border: 1px solid var(--admin-border);">
                    <label class="switch-label">
                        <input type="checkbox" name="is_published" value="1" class="switch-input" {{ old('is_published', $testimonial->is_published) ? 'checked' : '' }}>
                        <span><strong>Published</strong> (Visible on Frontend)</span>
                    </label>

                    <label class="switch-label">
                        <input type="checkbox" name="is_featured" value="1" class="switch-input" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                        <span><strong>Featured</strong> (Prioritized in Carousel)</span>
                    </label>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn-admin btn-admin-outline">Cancel</a>
                    <button type="submit" class="btn-admin btn-admin-gold">
                        Update Testimonial &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
