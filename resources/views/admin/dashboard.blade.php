@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

    <div class="page-header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back, {{ Auth::user()->name }}. Here is a summary of your website status and recent leads.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.projects.create') }}" class="btn-admin btn-admin-gold">
                + Add New Project
            </a>
            <a href="{{ route('admin.settings.index') }}" class="btn-admin btn-admin-outline">
                Site Settings
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div>
                <div class="kpi-label">Total Projects</div>
                <div class="kpi-value">{{ $totalProjects }}</div>
            </div>
            <div class="kpi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Published / Active</div>
                <div class="kpi-value" style="color: var(--admin-success);">{{ $publishedProjects }}</div>
            </div>
            <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: var(--admin-success);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Draft Projects</div>
                <div class="kpi-value">{{ $draftProjects }}</div>
            </div>
            <div class="kpi-icon" style="background: #F1F5F9; color: #64748B;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                </svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Unread Enquiries</div>
                <div class="kpi-value" style="color: var(--admin-danger);">{{ $unreadEnquiries }}</div>
            </div>
            <div class="kpi-icon" style="background: rgba(239, 68, 68, 0.12); color: var(--admin-danger);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Total Reviews</div>
                <div class="kpi-value">{{ $totalTestimonials }}</div>
            </div>
            <div class="kpi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Categories</div>
                <div class="kpi-value">{{ $totalCategories }}</div>
            </div>
            <div class="kpi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Projects & Recent Inquiries 2-Column Section -->
    <div style="display: grid; grid-template-columns: 1.35fr 1fr; gap: 24px;">
        
        <!-- Recent Projects -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Recent Projects</h3>
                <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">View All</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Link Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProjects as $p)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ $p->featured_image_url }}" alt="" style="width: 44px; height: 36px; object-fit: cover; border-radius: 4px;">
                                        <div>
                                            <strong style="color: var(--admin-sidebar-bg);">{{ $p->title }}</strong>
                                            <div style="font-size: 0.75rem; color: #64748B;">{{ $p->location ?? 'Victoria' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $p->category->name ?? 'Uncategorized' }}</td>
                                <td>
                                    @if($p->link_type === 'external')
                                        <span class="badge badge-warning" title="{{ $p->external_url }}">External ↗</span>
                                    @else
                                        <span class="badge badge-info">Internal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->is_published)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.projects.edit', $p->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #64748B;">No projects recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Inquiries -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Recent Client Enquiries</h3>
                <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">View Inbox</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEnquiries as $enq)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.enquiries.show', $enq->id) }}" style="font-weight: 600; color: var(--admin-sidebar-bg);">
                                        {{ $enq->name }}
                                    </a>
                                    <div style="font-size: 0.75rem; color: #64748B;">{{ $enq->email }}</div>
                                </td>
                                <td>
                                    <span style="font-size: 0.8rem;">{{ Str::limit($enq->project_type ?? 'General', 16) }}</span>
                                </td>
                                <td>
                                    @if($enq->status === 'unread')
                                        <span class="badge badge-danger">Unread</span>
                                    @elseif($enq->status === 'replied')
                                        <span class="badge badge-success">Replied</span>
                                    @else
                                        <span class="badge badge-info">Read</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.78rem; color: #64748B;">
                                    {{ $enq->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748B;">No contact enquiries yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
