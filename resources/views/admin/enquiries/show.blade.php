@extends('layouts.admin')

@section('title', 'Enquiry Details: ' . $enquiry->name)

@section('content')

    <div class="page-header">
        <div>
            <h1>Enquiry from {{ $enquiry->name }}</h1>
            <p>Received on {{ $enquiry->created_at->format('l, d F Y at h:i A') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline">&larr; Back to Enquiries</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Left: Enquiry Body -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Message Contents</h3>
                <span class="badge badge-gold">{{ $enquiry->project_type ?? 'General Consultation' }}</span>
            </div>
            <div class="admin-card-body">
                <div style="background: #F8FAFC; border-left: 4px solid var(--admin-gold); padding: 20px; border-radius: 4px; font-size: 1rem; line-height: 1.8; color: var(--admin-text-main); margin-bottom: 24px;">
                    {!! nl2br(e($enquiry->message)) !!}
                </div>

                <div style="display: flex; gap: 12px;">
                    <a href="mailto:{{ $enquiry->email }}?subject=Regarding your Arkle Homes Enquiry" class="btn-admin btn-admin-gold">
                        Reply via Email &rarr;
                    </a>
                    @if($enquiry->phone)
                        <a href="tel:{{ format_phone($enquiry->phone) }}" class="btn-admin btn-admin-outline">
                            Call Client: {{ $enquiry->phone }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Status & Staff Notes -->
        <div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Status & Internal Notes</h3>
                </div>
                <div class="admin-card-body">
                    <form action="{{ route('admin.enquiries.update', $enquiry->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="admin-form-group">
                            <label class="admin-form-label">Lead Status</label>
                            <select name="status" class="admin-form-control">
                                <option value="unread" {{ $enquiry->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ $enquiry->status === 'read' ? 'selected' : '' }}>Read / Under Review</option>
                                <option value="replied" {{ $enquiry->status === 'replied' ? 'selected' : '' }}>Replied / In Touch</option>
                            </select>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">Internal Staff Notes</label>
                            <textarea name="admin_notes" class="admin-form-control" rows="4" placeholder="Add follow-up notes or action items...">{{ $enquiry->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%; justify-content: center;">
                            Update Status &rarr;
                        </button>
                    </form>
                </div>
            </div>

            <!-- Client Metadata Card -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Client Contact Sheet</h3>
                </div>
                <div class="admin-card-body" style="font-size: 0.9rem; line-height: 1.8;">
                    <div><strong>Name:</strong> {{ $enquiry->name }}</div>
                    <div><strong>Email:</strong> <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></div>
                    <div><strong>Phone:</strong> {{ $enquiry->phone ?? 'Not provided' }}</div>
                    <div><strong>IP Address:</strong> <code>{{ $enquiry->ip_address ?? '127.0.0.1' }}</code></div>
                </div>
            </div>
        </div>

    </div>

@endsection
