@extends('layouts.admin')

@section('title', 'Commitment Statistics')

@section('content')

    <div class="page-header">
        <div>
            <h1>Commitment Statistics Counters</h1>
            <p>Edit the numbers and metrics displayed in the dark commitment section on the homepage.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
        
        <!-- Add Stat Form -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Add New Statistic Counter</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.statistics.store') }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label">Number / Metric *</label>
                        <input type="text" name="number" class="admin-form-control" placeholder="e.g. 50+ or 99%" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Metric Label *</label>
                        <input type="text" name="label" class="admin-form-control" placeholder="e.g. Homes Built" required>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Icon</label>
                        <select name="icon" class="admin-form-control">
                            <option value="home">Home Icon</option>
                            <option value="users">Clients / People Icon</option>
                            <option value="trophy">Trophy / Experience Icon</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">Display Order</label>
                        <input type="number" name="order" class="admin-form-control" value="0">
                    </div>

                    <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                        Save Counter &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistics List -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Active Counters ({{ $statistics->count() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Number</th>
                            <th>Label</th>
                            <th>Icon</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistics as $stat)
                            <tr>
                                <td>{{ $stat->order }}</td>
                                <td>
                                    <strong style="font-size: 1.4rem; color: var(--admin-gold); font-family: 'Playfair Display', serif;">
                                        {{ $stat->number }}
                                    </strong>
                                </td>
                                <td>
                                    <strong style="color: var(--admin-sidebar-bg);">{{ $stat->label }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $stat->icon }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.statistics.destroy', $stat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete counter?');">
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
