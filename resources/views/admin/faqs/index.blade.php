@extends('layouts.admin')

@section('title', 'Manage FAQs')

@section('content')

    <div class="page-header">
        <div>
            <h1>Frequently Asked Questions</h1>
            <p>Manage common client questions regarding timelines, contracts, and building permits.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add FAQ Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New FAQ</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.faqs.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Category *</label>
                        <input type="text" name="category" class="admin-form-control" placeholder="e.g. Pricing & Contracts" value="General" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Question *</label>
                        <input type="text" name="question" class="admin-form-control" placeholder="e.g. Do you offer fixed-price contracts?" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Answer *</label>
                        <textarea name="answer" class="admin-form-control" rows="5" placeholder="Detailed clear answer..." required></textarea>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" value="0">
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Save FAQ &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- FAQs List -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Existing Questions ({{ $faqs->count() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $f)
                            <tr>
                                <td>
                                    <span class="badge badge-gold">{{ $f->category }}</span>
                                </td>
                                <td>
                                    <strong>{{ $f->question }}</strong>
                                    <div style="font-size: 0.8rem; color: #64748B; margin-top: 4px;">{{ Str::limit($f->answer, 100) }}</div>
                                </td>
                                <td>
                                    @if($f->is_published)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.faqs.destroy', $f->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete FAQ?');">
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
