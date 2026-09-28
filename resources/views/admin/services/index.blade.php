@extends('layouts.admin')

@section('title', 'Feature Services')

@section('content')

    <div class="page-header">
        <div>
            <h1>Feature Services & Value Cards</h1>
            <p>Manage the 4 key service pillars highlighted on the homepage and about page.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add Service Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Feature Service</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Service Title *</label>
                        <input type="text" name="title" class="admin-form-control" placeholder="e.g. Master Craftsmanship" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Icon Type</label>
                        <select name="icon" class="admin-form-control">
                            <option value="home">Home / House Icon</option>
                            <option value="diamond">Diamond / Quality Icon</option>
                            <option value="settings">Gears / End-to-End Icon</option>
                            <option value="users">People / Client Focused Icon</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Short Description *</label>
                        <textarea name="description" class="admin-form-control" rows="3" placeholder="e.g. Tailored homes to suit your lifestyle." required></textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" value="0">
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Save Service &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Services List -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Active Feature Cards ({{ $services->count() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Icon</th>
                            <th>Title & Description</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $s)
                            <tr>
                                <td>{{ $s->order }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $s->icon }}</span>
                                </td>
                                <td>
                                    <strong>{{ $s->title }}</strong>
                                    <div style="font-size: 0.8rem; color: #64748B;">{{ $s->description }}</div>
                                </td>
                                <td>
                                    @if($s->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete service?');">
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
