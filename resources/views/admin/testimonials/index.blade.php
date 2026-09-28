@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')

    <div class="page-header">
        <div>
            <h1>Client Testimonials</h1>
            <p>Manage customer reviews, star ratings, customer avatars, order, and publishing status for the carousel.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert-success" style="margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 24px; align-items: start;">
        
        <!-- Add Testimonial Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Testimonial</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Name *</label>
                        <input type="text" name="client_name" class="admin-form-control" placeholder="e.g. S. Kaur" value="{{ old('client_name') }}" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Subtitle / Role</label>
                        <input type="text" name="client_role" class="admin-form-control" placeholder="Home Owner" value="{{ old('client_role', 'Home Owner') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Rating (Stars) *</label>
                        <select name="rating" class="admin-form-control" required>
                            <option value="5" selected>★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                            <option value="2">★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Review / Quote *</label>
                        <textarea name="review" class="admin-form-control" rows="4" placeholder="Client feedback..." required>{{ old('review') }}</textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Location (Optional)</label>
                        <input type="text" name="location" class="admin-form-control" placeholder="e.g. Geelong, VIC" value="{{ old('location') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" placeholder="0" value="{{ old('order', 0) }}">
                        <small style="color: #64748B; font-size: 0.78rem;">Lower numbers appear first in the carousel.</small>
                    </div>

                    <!-- Customer Image Upload -->
                    <div class="admin-form-group">
                        <label class="admin-form-label">Customer Image (Optional)</label>
                        <input type="file" name="avatar" class="admin-form-control" accept="image/*">
                        <small style="color: #64748B; font-size: 0.78rem;">Optional square portrait (JPG, PNG, WEBP).</small>
                    </div>

                    <div class="admin-form-group">
                        <label class="switch-label">
                            <input type="checkbox" name="is_published" value="1" class="switch-input" checked>
                            <span><strong>Published</strong> (Visible on Website)</span>
                        </label>
                    </div>

                    <div class="admin-form-group">
                        <label class="switch-label">
                            <input type="checkbox" name="is_featured" value="1" class="switch-input" checked>
                            <span>Featured on Homepage Carousel</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Save Testimonial &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Testimonials List -->
        <div class="admin-card">
            <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Existing Reviews ({{ $testimonials->total() }})</h3>
                <span style="font-size: 0.85rem; color: #64748B;">Active on Carousel: {{ $testimonials->where('is_published', true)->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th style="text-align: right; width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $t)
                            <tr>
                                <td>
                                    <span class="badge badge-info" style="font-size: 0.85rem; font-weight: 600;">
                                        #{{ $t->order }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if($t->avatar)
                                            <img src="{{ $t->avatar_url }}" alt="" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--admin-gold);">
                                        @else
                                            <div style="width: 38px; height: 38px; border-radius: 50%; background: #0D1C24; color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;">
                                                {{ substr($t->client_name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $t->client_name }}</strong>
                                            <div style="font-size: 0.75rem; color: #64748B;">
                                                {{ $t->client_role }} @if($t->location) &bull; {{ $t->location }} @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--admin-gold); font-size: 0.95rem; letter-spacing: 1px;">
                                        {{ str_repeat('★', $t->rating) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="max-width: 280px; font-size: 0.84rem; color: var(--admin-text-main); line-height: 1.4;">
                                        "{{ Str::limit($t->review, 85) }}"
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.testimonials.toggle-published', $t->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @if($t->is_published)
                                            <button type="submit" class="badge badge-success" style="cursor: pointer; border: none;" title="Click to Unpublish">
                                                ✓ Published
                                            </button>
                                        @else
                                            <button type="submit" class="badge badge-warning" style="cursor: pointer; border: none;" title="Click to Publish">
                                                ✕ Draft
                                            </button>
                                        @endif
                                    </form>
                                    @if($t->is_featured)
                                        <span class="badge badge-gold" style="margin-left: 4px;" title="Featured">Featured</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #64748B;">
                                    No testimonials found. Add your first review using the form on the left.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border);">
                {{ $testimonials->links() }}
            </div>
        </div>

    </div>

@endsection
