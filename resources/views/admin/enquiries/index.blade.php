@extends('layouts.admin')

@section('title', 'Contact Enquiries')

@section('content')

    <div class="page-header">
        <div>
            <h1>Contact Enquiries & Project Leads</h1>
            <p>Review customer submissions from the website contact form.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.enquiries.export') }}" class="btn-admin btn-admin-primary">
                ↓ Export Enquiries (CSV)
            </a>
        </div>
    </div>

    <!-- Filter / Search -->
    <div class="admin-card" style="margin-bottom: 20px;">
        <div class="admin-card-body" style="padding: 16px 20px;">
            <form action="{{ route('admin.enquiries.index') }}" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                <div style="flex-grow: 1; min-width: 220px;">
                    <input type="text" name="search" class="admin-form-control" placeholder="Search by client name, email or message..." value="{{ request('search') }}">
                </div>

                <div style="min-width: 150px;">
                    <select name="status" class="admin-form-control">
                        <option value="all">All Enquiries</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    </select>
                </div>

                <button type="submit" class="btn-admin btn-admin-primary">Filter</button>
                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Enquiries Table -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Client Details</th>
                        <th>Project Type</th>
                        <th>Message Preview</th>
                        <th>Date Received</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enq)
                        <tr style="{{ $enq->status === 'unread' ? 'background-color: #FFFDF5;' : '' }}">
                            <td>
                                @if($enq->status === 'unread')
                                    <span class="badge badge-danger">Unread</span>
                                @elseif($enq->status === 'replied')
                                    <span class="badge badge-success">Replied</span>
                                @else
                                    <span class="badge badge-info">Read</span>
                                @endif
                            </td>
                            <td>
                                <strong style="font-size: 0.95rem; color: var(--admin-sidebar-bg);">{{ $enq->name }}</strong>
                                <div style="font-size: 0.78rem; color: #64748B;">
                                    <a href="mailto:{{ $enq->email }}">{{ $enq->email }}</a>
                                    @if($enq->phone) &bull; {{ $enq->phone }} @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-gold">{{ $enq->project_type ?? 'General' }}</span>
                            </td>
                            <td>
                                <div style="max-width: 300px; font-size: 0.85rem; color: #475569;">
                                    {{ Str::limit($enq->message, 80) }}
                                </div>
                            </td>
                            <td style="font-size: 0.8rem; color: #64748B;">
                                {{ $enq->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('admin.enquiries.show', $enq->id) }}" class="btn-admin btn-admin-primary btn-admin-sm">
                                        View Details &rarr;
                                    </a>
                                    <form action="{{ route('admin.enquiries.destroy', $enq->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete enquiry from {{ $enq->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #64748B;">
                                No enquiries found in this view.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border);">
            {{ $enquiries->links() }}
        </div>
    </div>

@endsection
