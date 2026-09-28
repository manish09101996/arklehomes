@extends('layouts.admin')

@section('title', 'SEO Management')

@section('content')

    <div class="page-header">
        <div>
            <h1>Search Engine Optimization (SEO) CMS</h1>
            <p>Fine-tune meta tags, social sharing cards, Open Graph data, and search engine directives.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn-admin btn-admin-outline">View Sitemap.xml ↗</a>
            <a href="{{ url('/robots.txt') }}" target="_blank" class="btn-admin btn-admin-outline">View Robots.txt ↗</a>
        </div>
    </div>

    @foreach($seoList as $seo)
        <div class="admin-card" style="margin-bottom: 24px;">
            <div class="admin-card-header">
                <div>
                    <h3>{{ $seo->url_path === '/' ? 'Homepage' : ucwords(trim($seo->url_path, '/')) }}</h3>
                    <code style="font-size: 0.78rem; color: #64748B;">Path: {{ $seo->url_path }}</code>
                </div>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.seo.update', $seo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Meta Title (Browser Tab & Search Result)</label>
                            <input type="text" name="meta_title" class="admin-form-control" value="{{ $seo->meta_title }}" required>
                        </div>

                        <div class="col-6 admin-form-group">
                            <label class="admin-form-label">Canonical URL</label>
                            <input type="url" name="canonical_url" class="admin-form-control" value="{{ $seo->canonical_url }}" placeholder="https://arklehomes.com.au{{ $seo->url_path }}">
                        </div>

                        <div class="col-12 admin-form-group">
                            <label class="admin-form-label">Meta Description (150-160 characters recommended)</label>
                            <textarea name="meta_description" class="admin-form-control" rows="2" required>{{ $seo->meta_description }}</textarea>
                        </div>

                        <div class="col-8 admin-form-group">
                            <label class="admin-form-label">Keywords (Comma Separated)</label>
                            <input type="text" name="meta_keywords" class="admin-form-control" value="{{ $seo->meta_keywords }}">
                        </div>

                        <div class="col-4 admin-form-group">
                            <label class="admin-form-label">Custom Open Graph / Social Image</label>
                            <input type="file" name="og_image" class="admin-form-control" accept="image/*">
                        </div>

                        <div class="col-12" style="text-align: right;">
                            <button type="submit" class="btn-admin btn-admin-gold">
                                Save SEO Changes &rarr;
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection
