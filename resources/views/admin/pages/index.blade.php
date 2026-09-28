@extends('layouts.admin')

@section('title', 'Manage Pages')

@section('content')

    <div class="page-header">
        <div>
            <h1>Website Pages & Content</h1>
            <p>Every page and content section can be customized dynamically.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>URL Slug</th>
                        <th>Sections</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $p)
                        <tr>
                            <td>
                                <strong style="font-size: 0.95rem; color: var(--admin-sidebar-bg);">{{ $p->title }}</strong>
                                @if($p->subtitle)
                                    <div style="font-size: 0.78rem; color: #64748B;">{{ Str::limit($p->subtitle, 60) }}</div>
                                @endif
                            </td>
                            <td>
                                <code>/{{ $p->slug === 'home' ? '' : $p->slug }}</code>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $p->sections_count }} dynamic sections</span>
                            </td>
                            <td>
                                @if($p->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ url('/' . ($p->slug === 'home' ? '' : $p->slug)) }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm">
                                    Preview ↗
                                </a>
                                <a href="{{ route('admin.pages.edit', $p->id) }}" class="btn-admin btn-admin-gold btn-admin-sm">
                                    Edit Page & Sections &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
