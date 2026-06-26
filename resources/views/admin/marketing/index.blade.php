@extends('admin.layouts.app')

@section('title', 'Marketing - StyleHub Admin')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }
    .btn-primary-custom {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }
    .btn-primary-custom:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.3);
        color: #fff;
    }

    .marketing-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        padding: 24px 28px;
        transition: all 0.3s;
        height: 100%;
        text-align: center;
    }
    .marketing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .marketing-card .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 12px;
    }
    .marketing-card .icon-circle.primary { background: #fef0f0; color: #db4444; }
    .marketing-card .icon-circle.success { background: #e8f5e9; color: #28a745; }
    .marketing-card .icon-circle.info { background: #e3f2fd; color: #0d6efd; }
    .marketing-card .icon-circle.warning { background: #fef3e2; color: #ff9800; }
    .marketing-card h5 { font-weight: 700; font-size: 18px; color: #1a1a2e; }
    .marketing-card p { color: #8c8c9c; font-size: 14px; margin-bottom: 16px; }
    .marketing-card .btn-outline {
        border: 1px solid #ddd;
        background: transparent;
        padding: 8px 20px;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        transition: all 0.3s;
    }
    .marketing-card .btn-outline:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
        white-space: nowrap;
        display: inline-block;
    }
    .badge-status.active { background: #d4edda; color: #155724; }
    .badge-status.completed { background: #cce5ff; color: #004085; }
    .badge-status.draft { background: #fff3cd; color: #856404; }

    .table-premium {
        font-size: 14px;
        margin-bottom: 0;
    }
    .table-premium thead th {
        background: #f8f9fa;
        color: #666;
        font-weight: 600;
        padding: 10px 18px;
        border-bottom: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .table-premium tbody td {
        padding: 10px 18px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background: transparent;
        color: #666;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .action-btn:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .action-btn.view:hover {
        background: #0d6efd;
        border-color: #0d6efd;
    }
    .action-btn.edit:hover {
        background: #ff9800;
        border-color: #ff9800;
    }
    .action-btn.delete:hover {
        background: #dc3545;
        border-color: #dc3545;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-bullhorn"></i> Marketing</h4>
        <p>Manage your marketing campaigns</p>
    </div>
    <a href="{{ route('admin.marketing.create') }}" class="btn-primary-custom">
        <i class="fas fa-plus-circle"></i> New Campaign
    </a>
</div>

<!-- Marketing Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="marketing-card">
            <div class="icon-circle primary">
                <i class="fas fa-envelope"></i>
            </div>
            <h5>Email Campaigns</h5>
            <p>Send newsletters to customers</p>
            <a href="{{ route('admin.marketing.create') }}" class="btn-outline">Manage</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="marketing-card">
            <div class="icon-circle success">
                <i class="fas fa-tags"></i>
            </div>
            <h5>Discount Offers</h5>
            <p>Create special promotions</p>
            <a href="{{ route('admin.marketing.create') }}" class="btn-outline">Manage</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="marketing-card">
            <div class="icon-circle info">
                <i class="fas fa-share-alt"></i>
            </div>
            <h5>Social Media</h5>
            <p>Connect social platforms</p>
            <a href="{{ route('admin.marketing.create') }}" class="btn-outline">Manage</a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="marketing-card">
            <div class="icon-circle warning">
                <i class="fas fa-bell"></i>
            </div>
            <h5>Push Notifications</h5>
            <p>Send real-time alerts</p>
            <a href="{{ route('admin.marketing.create') }}" class="btn-outline">Manage</a>
        </div>
    </div>
</div>

<!-- Recent Campaigns -->
<div class="chart-card">
    <div class="card-header-custom">
        <span class="title"><i class="fas fa-list"></i> Recent Campaigns</span>
        <span style="font-size: 13px; color: #999;">Last 30 days</span>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Campaign Name</th>
                        <th>Type</th>
                        <th>Sent</th>
                        <th>Opened</th>
                        <th>Status</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns ?? [] as $campaign)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $campaign['name'] }}</strong></td>
                        <td>{{ $campaign['type'] }}</td>
                        <td>{{ number_format($campaign['sent']) }}</td>
                        <td>{{ number_format($campaign['opened']) }}</td>
                        <td>
                            <span class="badge-status {{ $campaign['status'] }}">
                                {{ ucfirst($campaign['status']) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- ✅ VIEW BUTTON --}}
                                <a href="{{ route('admin.marketing.show', $campaign['id']) }}" 
                                   class="action-btn view" title="View">
                                    <i class="fas fa-eye" style="font-size: 13px;"></i>
                                </a>
                                
                                {{-- ✅ EDIT BUTTON --}}
                                <a href="{{ route('admin.marketing.edit', $campaign['id']) }}" 
                                   class="action-btn edit" title="Edit">
                                    <i class="fas fa-edit" style="font-size: 13px;"></i>
                                </a>
                                
                                {{-- ✅ TOGGLE STATUS BUTTON --}}
                                <form action="{{ route('admin.marketing.toggle', $campaign['id']) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn" title="Toggle Status">
                                        <i class="fas fa-sync" style="font-size: 13px;"></i>
                                    </button>
                                </form>
                                
                                {{-- ✅ DELETE BUTTON --}}
                                <form action="{{ route('admin.marketing.destroy', $campaign['id']) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" 
                                            title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash" style="font-size: 13px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-bullhorn" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                            No campaigns found. Create your first campaign!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection