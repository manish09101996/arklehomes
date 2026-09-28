@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')

    <div class="page-header">
        <div>
            <h1>Client Testimonials</h1>
            <p>Manage customer reviews, star ratings, and homeowner quotes.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add Testimonial Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Review</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Name *</label>
                        <input type="text" name="client_name" class="admin-form-control" placeholder="e.g. S. Kaur" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Client Subtitle / Role</label>
                        <input type="text" name="client_role" class="admin-form-control" placeholder="Home Owner" value="Home Owner">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Rating (Stars) *</label>
                        <select name="rating" class="admin-form-control" required>
                            <option value="5" selected>★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Review / Quote *</label>
                        <textarea name="review" class="admin-form-control" rows="4" placeholder="Client feedback..." required></textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Location (Optional)</label>
                        <input type="text" name="location" class="admin-form-control" placeholder="e.g. Geelong, VIC">
                    </div>

                    <div class="admin-form-group">
                        <label class="switch-label">
                            <input type="checkbox" name="is_featured" value="1" class="switch-input" checked>
                            <span>Featured on Homepage</span>
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
            <div class="admin-card-header">
                <h3>Existing Reviews ({{ $testimonials->total() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Homepage</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $t)
                            <tr>
                                <td>
                                    <strong>{{ $t->client_name }}</strong>
                                    <div style="font-size: 0.75rem; color: #64748B;">{{ $t->client_role }}</div>
                                </td>
                                <td>
                                    <span style="color: var(--admin-gold); font-size: 1rem;">
                                        {{ str_repeat('★', $t->rating) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="max-width: 320px; font-size: 0.85rem; color: var(--admin-text-main);">
                                        "{{ Str::limit($t->review, 100) }}"
                                    </div>
                                </td>
                                <td>
                                    @if($t->is_featured)
                                        <span class="badge badge-gold">Featured</span>
                                    @else
                                        <span class="badge badge-info">Archive</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border);">
                {{ $testimonials->links() }}
            </div>
        </div>

    </div>

@endsection
