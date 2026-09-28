@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')

    <div class="page-header">
        <div>
            <h1>Centralized Site Settings</h1>
            <p>Modify core business information, homepage sections, contact channels, and branding.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Business & Contact Details -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>General Business Information</h3>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Business Name</label>
                        <input type="text" name="site_name" class="admin-form-control" value="{{ setting('site_name') }}" required>
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Brand Tagline</label>
                        <input type="text" name="site_tagline" class="admin-form-control" value="{{ setting('site_tagline') }}">
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Office Phone Number</label>
                        <input type="text" name="site_phone" class="admin-form-control" value="{{ setting('site_phone') }}">
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Contact Email Address</label>
                        <input type="email" name="site_email" class="admin-form-control" value="{{ setting('site_email') }}">
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">ABN / Builder License</label>
                        <input type="text" name="site_abn" class="admin-form-control" value="{{ setting('site_abn') }}">
                    </div>
                    <div class="col-8 admin-form-group">
                        <label class="admin-form-label">Physical Office Address</label>
                        <input type="text" name="site_address" class="admin-form-control" value="{{ setting('site_address') }}">
                    </div>
                    <div class="col-4 admin-form-group">
                        <label class="admin-form-label">Opening Hours</label>
                        <input type="text" name="opening_hours" class="admin-form-control" value="{{ setting('opening_hours') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Google Maps Embed URL</label>
                        <input type="text" name="google_maps_embed" class="admin-form-control" value="{{ setting('google_maps_embed') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Homepage Hero Section CMS -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Homepage Hero Section Content</h3>
                <span class="badge badge-gold">100% Dynamic</span>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Hero Small Eyebrow Text</label>
                        <input type="text" name="hero_eyebrow" class="admin-form-control" value="{{ setting('hero_eyebrow') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Main Heading (White)</label>
                        <input type="text" name="hero_heading_1" class="admin-form-control" value="{{ setting('hero_heading_1') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Highlight Heading (Gold Accent)</label>
                        <input type="text" name="hero_heading_2" class="admin-form-control" value="{{ setting('hero_heading_2') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Hero Description</label>
                        <textarea name="hero_description" class="admin-form-control" rows="2">{{ setting('hero_description') }}</textarea>
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Primary Button Text</label>
                        <input type="text" name="hero_btn_1_text" class="admin-form-control" value="{{ setting('hero_btn_1_text') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Primary Button URL</label>
                        <input type="text" name="hero_btn_1_url" class="admin-form-control" value="{{ setting('hero_btn_1_url') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Secondary Video Button Text</label>
                        <input type="text" name="hero_btn_2_text" class="admin-form-control" value="{{ setting('hero_btn_2_text') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Video Modal URL (YouTube/Vimeo embed)</label>
                        <input type="text" name="hero_video_url" class="admin-form-control" value="{{ setting('hero_video_url') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Hero Background Image</label>
                        <input type="file" name="hero_bg_image" class="admin-form-control" accept="image/*">
                        @if(setting('hero_bg_image'))
                            <small style="color: #64748B;">Current: {{ setting('hero_bg_image') }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Homepage About Section CMS -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Homepage About Section</h3>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Eyebrow</label>
                        <input type="text" name="about_eyebrow" class="admin-form-control" value="{{ setting('about_eyebrow') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Heading</label>
                        <input type="text" name="about_heading" class="admin-form-control" value="{{ setting('about_heading') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea name="about_description" class="admin-form-control" rows="3">{{ setting('about_description') }}</textarea>
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Button Text</label>
                        <input type="text" name="about_btn_text" class="admin-form-control" value="{{ setting('about_btn_text') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Button URL</label>
                        <input type="text" name="about_btn_url" class="admin-form-control" value="{{ setting('about_btn_url') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">About Kitchen / Interior Image</label>
                        <input type="file" name="about_image" class="admin-form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- Commitment Section Background & Text -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Dark Commitment Section</h3>
            </div>
            <div class="admin-card-body">
                <div class="form-grid">
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Eyebrow</label>
                        <input type="text" name="commitment_eyebrow" class="admin-form-control" value="{{ setting('commitment_eyebrow') }}">
                    </div>
                    <div class="col-6 admin-form-group">
                        <label class="admin-form-label">Heading</label>
                        <input type="text" name="commitment_heading" class="admin-form-control" value="{{ setting('commitment_heading') }}">
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea name="commitment_description" class="admin-form-control" rows="2">{{ setting('commitment_description') }}</textarea>
                    </div>
                    <div class="col-12 admin-form-group">
                        <label class="admin-form-label">Background Dusk Photo</label>
                        <input type="file" name="commitment_bg" class="admin-form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 50px;">
            <button type="submit" class="btn-admin btn-admin-gold" style="padding: 14px 36px; font-size: 1rem;">
                Save All Site Settings &rarr;
            </button>
        </div>
    </form>

@endsection
