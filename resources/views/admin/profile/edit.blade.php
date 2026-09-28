@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')

    <div class="page-header">
        <div>
            <h1>Admin Profile</h1>
            <p>Update your personal account credentials and security settings.</p>
        </div>
    </div>

    <div style="max-width: 680px;">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Account Information</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-group">
                        <label class="admin-form-label">Full Name *</label>
                        <input type="text" name="name" class="admin-form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Email Address *</label>
                        <input type="email" name="email" class="admin-form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 24px 0;">

                    <h4 style="font-size: 1rem; color: var(--admin-sidebar-bg); margin-bottom: 16px;">Change Password (Optional)</h4>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Current Password</label>
                        <input type="password" name="current_password" class="admin-form-control" placeholder="Required if changing password">
                    </div>

                    <div class="form-grid">
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">New Password</label>
                            <input type="password" name="new_password" class="admin-form-control" placeholder="Min 8 characters">
                        </div>
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="admin-form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="padding: 12px 28px; margin-top: 10px;">
                        Update Profile &rarr;
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
