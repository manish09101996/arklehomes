@extends('layouts.admin')

@section('title', 'Header & Footer CMS')

@section('content')

    <div class="page-header">
        <div>
            <h1>Header & Footer Management</h1>
            <p>Customize global navigation branding, CTA buttons, contact details, and copyright information.</p>
        </div>
    </div>

    <form action="{{ route('admin.header-footer.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            
            <!-- Header Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Header Configuration</h3>
                </div>
                <div class="admin-card-body">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Current Header Logo</label>
                        <div style="background: #0D1C24; padding: 14px; border-radius: 6px; display: inline-block; margin-bottom: 10px;">
                            <img src="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}" alt="" style="height: 50px;">
                        </div>
                        <input type="file" name="site_logo" class="admin-form-control" accept="image/*">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Header Call-to-Action Text</label>
                        <input type="text" name="header_cta_text" class="admin-form-control" value="{{ setting('header_cta_text', 'Get in Touch') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Header Call-to-Action URL</label>
                        <input type="text" name="header_cta_url" class="admin-form-control" value="{{ setting('header_cta_url', '/contact') }}">
                    </div>
                </div>
            </div>

            <!-- Footer Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Footer Configuration</h3>
                </div>
                <div class="admin-card-body">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Footer Brand Bio / Description</label>
                        <textarea name="footer_description" class="admin-form-control" rows="3">{{ setting('footer_description') }}</textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Office Address</label>
                        <input type="text" name="site_address" class="admin-form-control" value="{{ setting('site_address') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Phone Number</label>
                        <input type="text" name="site_phone" class="admin-form-control" value="{{ setting('site_phone') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Email Address</label>
                        <input type="email" name="site_email" class="admin-form-control" value="{{ setting('site_email') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Copyright Text</label>
                        <input type="text" name="footer_copyright" class="admin-form-control" value="{{ setting('footer_copyright') }}">
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="admin-card" style="grid-column: span 2;">
                <div class="admin-card-header">
                    <h3>Social Media Links</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-grid">
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Facebook Profile URL</label>
                            <input type="url" name="facebook_url" class="admin-form-control" value="{{ setting('facebook_url') }}">
                        </div>
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Instagram Profile URL</label>
                            <input type="url" name="instagram_url" class="admin-form-control" value="{{ setting('instagram_url') }}">
                        </div>
                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">LinkedIn Profile URL</label>
                            <input type="url" name="linkedin_url" class="admin-form-control" value="{{ setting('linkedin_url') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="padding: 12px 28px;">
                        Save Header & Footer Settings &rarr;
                    </button>
                </div>
            </div>

        </div>
    </form>

@endsection
