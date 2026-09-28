@extends('layouts.admin')

@section('title', 'Manage Projects')

@section('content')

    <div class="page-header">
        <div>
            <h1>Projects Portfolio</h1>
            <p>Manage all architectural builds, custom homes, and property showcases.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.projects.create') }}" class="btn-admin btn-admin-gold">
                + Add New Project
            </a>
        </div>
    </div>

    <!-- Filter / Search Bar -->
    <div class="admin-card" style="margin-bottom: 20px;">
        <div class="admin-card-body" style="padding: 16px 20px;">
            <form action="{{ route('admin.projects.index') }}" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                <div style="flex-grow: 1; min-width: 200px;">
                    <input type="text" name="search" class="admin-form-control" placeholder="Search by title or location..." value="{{ request('search') }}">
                </div>

                <div style="min-width: 160px;">
                    <select name="category" class="admin-form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="min-width: 140px;">
                    <select name="status" class="admin-form-control">
                        <option value="">All Statuses</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <button type="submit" class="btn-admin btn-admin-primary">Filter</button>
                @if(request()->anyFilled(['search', 'category', 'status']))
                    <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Img</th>
                        <th>Title & Location</th>
                        <th>Category</th>
                        <th>Link Behavior</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->featured_image_url }}" alt="" style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                            </td>
                            <td>
                                <div>
                                    <strong style="font-size: 0.95rem; color: var(--admin-sidebar-bg);">{{ $p->title }}</strong>
                                    <div style="font-size: 0.78rem; color: #64748B;">
                                        {{ $p->location ?? 'No location' }} &bull; {{ $p->images_count }} photos &bull; {{ $p->project_type ?? 'Residential' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-gold">{{ $p->category->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td>
                                @if($p->link_type === 'external')
                                    <span class="badge badge-warning" title="{{ $p->external_url }}">
                                        External URL ↗
                                    </span>
                                @else
                                    <span class="badge badge-info">Internal Page</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn-admin btn-admin-sm {{ $p->is_featured ? 'btn-admin-gold' : 'btn-admin-outline' }}"
                                        data-toggle-action
                                        data-url="{{ route('admin.projects.toggle-featured', $p->id) }}">
                                    {{ $p->is_featured ? '★ Featured' : '☆ Normal' }}
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn-admin btn-admin-sm {{ $p->is_published ? 'btn-admin-primary' : 'btn-admin-outline' }}"
                                        data-toggle-action
                                        data-url="{{ route('admin.projects.toggle-published', $p->id) }}">
                                    {{ $p->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ $p->destination_url }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm" title="View destination">
                                        View ↗
                                    </a>
                                    
                                    <form action="{{ route('admin.projects.duplicate', $p->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-admin btn-admin-outline btn-admin-sm" title="Duplicate project">
                                            Duplicate
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.projects.edit', $p->id) }}" class="btn-admin btn-admin-primary btn-admin-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete project \'{{ $p->title }}\'?');">
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
                            <td colspan="7" style="text-align: center; padding: 40px; color: #64748B;">
                                No projects found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border);">
            {{ $projects->links() }}
        </div>
    </div>

@endsection
