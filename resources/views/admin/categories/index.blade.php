@extends('layouts.admin')

@section('title', 'Project Categories')

@section('content')

    <div class="page-header">
        <div>
            <h1>Project Categories</h1>
            <p>Manage categories used for portfolio classification and frontend filtering.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add Category Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Category</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Category Name *</label>
                        <input type="text" name="name" class="admin-form-control" placeholder="e.g. Architectural Renovation" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="admin-form-control" placeholder="architectural-renovation">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea name="description" class="admin-form-control" rows="3" placeholder="Brief category description..."></textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" value="0">
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Save Category &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Existing Categories ({{ $categories->count() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Projects</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->order }}</td>
                                <td>
                                    <strong>{{ $cat->name }}</strong>
                                    @if($cat->description)
                                        <div style="font-size: 0.75rem; color: #64748B;">{{ $cat->description }}</div>
                                    @endif
                                </td>
                                <td><code>{{ $cat->slug }}</code></td>
                                <td>
                                    <span class="badge badge-gold">{{ $cat->projects_count }} builds</span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete category {{ $cat->name }}?');">
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
        </div>

    </div>

@endsection
