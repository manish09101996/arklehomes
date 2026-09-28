@extends('layouts.admin')

@section('title', 'Navigation Menus')

@section('content')

    <div class="page-header">
        <div>
            <h1>Navigation Menus CMS</h1>
            <p>Manage header links, dropdowns, and footer navigation blocks.</p>
        </div>
    </div>

    @foreach($menus as $menu)
        <div class="admin-card" style="margin-bottom: 30px;">
            <div class="admin-card-header">
                <div>
                    <h3>{{ $menu->name }}</h3>
                    <code style="font-size: 0.75rem; color: #64748B;">location: {{ $menu->location }}</code>
                </div>
            </div>
            <div class="admin-card-body">
                
                <!-- Existing Menu Items Table -->
                <div class="table-responsive" style="margin-bottom: 24px;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Label</th>
                                <th>Destination URL</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menu->items as $item)
                                <tr>
                                    <td>{{ $item->order }}</td>
                                    <td><strong>{{ $item->label }}</strong></td>
                                    <td><code>{{ $item->url }}</code></td>
                                    <td>{{ $item->target }}</td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-warning">Hidden</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.menus.items.delete', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Remove link \'{{ $item->label }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #64748B;">No menu items in this location.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Add Item Form for this Menu -->
                <div style="background: #F8FAFC; padding: 18px; border-radius: 6px; border: 1px solid var(--admin-border);">
                    <h4 style="font-size: 0.95rem; margin-bottom: 12px; color: var(--admin-sidebar-bg);">+ Add Link to {{ $menu->name }}</h4>
                    <form action="{{ route('admin.menus.items.store', $menu->id) }}" method="POST">
                        @csrf
                        <div class="form-grid">
                            <div class="col-4 admin-form-group" style="margin-bottom: 0;">
                                <input type="text" name="label" class="admin-form-control" placeholder="Label (e.g. Gallery)" required>
                            </div>
                            <div class="col-4 admin-form-group" style="margin-bottom: 0;">
                                <input type="text" name="url" class="admin-form-control" placeholder="URL (e.g. /projects or https://...)" required>
                            </div>
                            <div class="col-2 admin-form-group" style="margin-bottom: 0;">
                                <select name="target" class="admin-form-control">
                                    <option value="_self">Same Tab (_self)</option>
                                    <option value="_blank">New Tab (_blank)</option>
                                </select>
                            </div>
                            <div class="col-2 admin-form-group" style="margin-bottom: 0;">
                                <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center;">
                                    Add Link &rarr;
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endforeach

@endsection
