@extends('layouts.admin')

@section('title', 'Admin User Management')

@section('content')

    <div class="page-header">
        <div>
            <h1>Admin Staff & Access Control</h1>
            <p>Manage users with access to the Arkle Homes Content Management System.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add User Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Administrator</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Full Name *</label>
                        <input type="text" name="name" class="admin-form-control" placeholder="e.g. John Doe" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Email Address *</label>
                        <input type="email" name="email" class="admin-form-control" placeholder="john@arklehomes.com.au" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Password * (min 8 characters)</label>
                        <input type="password" name="password" class="admin-form-control" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">System Role *</label>
                        <select name="role" class="admin-form-control" required>
                            <option value="editor">Editor (Projects, Testimonials, Media)</option>
                            <option value="admin">Administrator (All Content & Settings)</option>
                            <option value="super_admin">Super Administrator (Full System Control)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Create User &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Registered Staff ({{ $users->count() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $u->name }}</strong>
                                            <div style="font-size: 0.75rem; color: #64748B;">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($u->role === 'super_admin')
                                        <span class="badge badge-gold">Super Admin</span>
                                    @elseif($u->role === 'admin')
                                        <span class="badge badge-primary" style="background: #1A323F; color: #fff;">Admin</span>
                                    @else
                                        <span class="badge badge-info">Editor</span>
                                    @endif
                                </td>
                                <td>
                                    @if($u->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.8rem; color: #64748B;">
                                    {{ $u->created_at->format('d M Y') }}
                                </td>
                                <td style="text-align: right;">
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Remove access for {{ $u->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                                        </form>
                                    @else
                                        <span style="font-size: 0.75rem; color: #94A3B8;">Current Account</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
