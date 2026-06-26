@extends('admin.layouts.app')

@section('title', $campaign['name'] . ' - StyleHub Admin')

@section('content')
<style>
    /* ========================================
       PAGE HEADER
       ======================================== */
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
        font-size: 24px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 10px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #e0e0e0;
    }
    .btn-edit {
        background: #ff9800;
        color: #fff;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-edit:hover {
        background: #e68900;
        color: #fff;
    }
    .btn-delete {
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    .btn-delete:hover {
        background: #c0392b;
        color: #fff;
    }

    /* ========================================
       STATS CARDS
       ======================================== */
    .stat-box {
        background: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .stat-box .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-box .icon-box.primary { background: #fef0f0; color: #db4444; }
    .stat-box .icon-box.success { background: #e8f5e9; color: #28a745; }
    .stat-box .icon-box.info { background: #e3f2fd; color: #0d6efd; }
    .stat-box .icon-box.warning { background: #fef3e2; color: #ff9800; }

    .stat-box .stat-number {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .stat-box .stat-label {
        font-size: 13px;
        color: #8c8c9c;
        font-weight: 500;
    }

    /* ========================================
       DETAIL CARD
       ======================================== */
    .detail-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        padding: 24px 28px;
        margin-bottom: 24px;
    }
    .detail-card .section-title {
        font-weight: 600;
        font-size: 16px;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f8f9fa;
    }
    .detail-card .section-title i {
        color: #db4444;
        margin-right: 8px;
    }
    .detail-card .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 24px;
    }
    .detail-card .info-item {
        display: flex;
        flex-direction: column;
        padding: 6px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    .detail-card .info-item .label {
        font-size: 12px;
        color: #8c8c9c;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .detail-card .info-item .value {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin-top: 2px;
    }

    /* ========================================
       BADGE
       ======================================== */
    .badge-status {
        padding: 4px 14px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
        white-space: nowrap;
        display: inline-block;
    }
    .badge-status.active { background: #d4edda; color: #155724; }
    .badge-status.completed { background: #cce5ff; color: #004085; }
    .badge-status.draft { background: #fff3cd; color: #856404; }

    /* ========================================
       PROGRESS
       ======================================== */
    .progress-item {
        margin-bottom: 16px;
    }
    .progress-item:last-child {
        margin-bottom: 0;
    }
    .progress-item .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .progress-item .progress-header span {
        font-size: 13px;
        color: #666;
    }
    .progress-item .progress-header strong {
        font-size: 13px;
        color: #1a1a2e;
    }
    .progress-track {
        height: 6px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-track .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.6s ease;
    }
    .progress-track .progress-fill.primary { background: linear-gradient(90deg, #db4444, #ff6b6b); }
    .progress-track .progress-fill.blue { background: linear-gradient(90deg, #0d6efd, #4facfe); }
    .progress-track .progress-fill.green { background: linear-gradient(90deg, #28a745, #43e97b); }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .detail-card {
            padding: 16px;
        }
        .detail-card .info-grid {
            grid-template-columns: 1fr;
        }
        .stat-box {
            padding: 14px 16px;
        }
        .stat-box .stat-number {
            font-size: 18px;
        }
        .stat-box .icon-box {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
</style>

<!-- ========================================
     PAGE HEADER
     ======================================== -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-bullhorn"></i> {{ $campaign['name'] }}</h4>
        <p>View campaign details</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.marketing.edit', $campaign['id']) }}" class="btn-edit">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.marketing.destroy', $campaign['id']) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this campaign?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
        <a href="{{ route('admin.marketing.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- ========================================
     STATS CARDS
     ======================================== -->
<div class="row g-3 mb-4">
    @php
        $openRate = $campaign['sent'] > 0 ? round(($campaign['opened'] / $campaign['sent']) * 100) : 0;
    @endphp

    <div class="col-md-3 col-6">
        <div class="stat-box">
            <div class="icon-box primary"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-number">{{ number_format($campaign['sent']) }}</div>
                <div class="stat-label">Total Sent</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-box">
            <div class="icon-box success"><i class="fas fa-envelope-open"></i></div>
            <div>
                <div class="stat-number">{{ number_format($campaign['opened']) }}</div>
                <div class="stat-label">Total Opened</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-box">
            <div class="icon-box info"><i class="fas fa-percent"></i></div>
            <div>
                <div class="stat-number">{{ $openRate }}%</div>
                <div class="stat-label">Open Rate</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-box">
            <div class="icon-box warning"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="stat-number">{{ $campaign['created_at'] ?? 'N/A' }}</div>
                <div class="stat-label">Created Date</div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================
     CAMPAIGN DETAILS
     ======================================== -->
<div class="detail-card">
    <div class="section-title"><i class="fas fa-info-circle"></i> Campaign Information</div>

    <div class="info-grid">
        <div class="info-item">
            <span class="label">Campaign Name</span>
            <span class="value">{{ $campaign['name'] }}</span>
        </div>
        <div class="info-item">
            <span class="label">Campaign Type</span>
            <span class="value">
                @if($campaign['type'] == 'Email')
                    <i class="fas fa-envelope" style="color: #db4444;"></i>
                @elseif($campaign['type'] == 'Push Notification')
                    <i class="fas fa-bell" style="color: #db4444;"></i>
                @elseif($campaign['type'] == 'Social Media')
                    <i class="fas fa-share-alt" style="color: #db4444;"></i>
                @elseif($campaign['type'] == 'SMS')
                    <i class="fas fa-sms" style="color: #db4444;"></i>
                @endif
                {{ $campaign['type'] }}
            </span>
        </div>
        <div class="info-item">
            <span class="label">Status</span>
            <span class="value">
                <span class="badge-status {{ $campaign['status'] }}">
                    @if($campaign['status'] == 'active')
                        <i class="fas fa-circle" style="font-size: 8px; margin-right: 4px;"></i>
                    @elseif($campaign['status'] == 'completed')
                        <i class="fas fa-check-circle" style="font-size: 12px; margin-right: 4px;"></i>
                    @else
                        <i class="fas fa-pencil-alt" style="font-size: 12px; margin-right: 4px;"></i>
                    @endif
                    {{ ucfirst($campaign['status']) }}
                </span>
            </span>
        </div>
        <div class="info-item">
            <span class="label">Sent To</span>
            <span class="value">{{ number_format($campaign['sent']) }} recipients</span>
        </div>
        <div class="info-item">
            <span class="label">Opened By</span>
            <span class="value">{{ number_format($campaign['opened']) }} recipients</span>
        </div>
        <div class="info-item">
            <span class="label">Unopened</span>
            <span class="value">{{ number_format($campaign['sent'] - $campaign['opened']) }} recipients</span>
        </div>
    </div>
</div>

<!-- ========================================
     PERFORMANCE METRICS
     ======================================== -->
<div class="detail-card">
    <div class="section-title"><i class="fas fa-chart-line"></i> Performance Metrics</div>

    @php
        $engagementRate = $campaign['sent'] > 0 ? round((($campaign['opened'] + 50) / $campaign['sent']) * 100) : 0;
        $bounceRate = $campaign['sent'] > 0 ? round((($campaign['sent'] - $campaign['opened']) / $campaign['sent']) * 100) : 0;
    @endphp

    <div class="row g-4">
        <div class="col-md-6">
            <div class="progress-item">
                <div class="progress-header">
                    <span>Open Rate</span>
                    <strong>{{ $openRate }}%</strong>
                </div>
                <div class="progress-track">
                    <div class="progress-fill primary" style="width: {{ $openRate }}%;"></div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-header">
                    <span>Engagement Rate</span>
                    <strong>{{ $engagementRate }}%</strong>
                </div>
                <div class="progress-track">
                    <div class="progress-fill blue" style="width: {{ $engagementRate }}%;"></div>
                </div>
            </div>
            <div class="progress-item">
                <div class="progress-header">
                    <span>Bounce Rate</span>
                    <strong>{{ $bounceRate }}%</strong>
                </div>
                <div class="progress-track">
                    <div class="progress-fill green" style="width: {{ $bounceRate }}%;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div style="background: #f8f9fa; border-radius: 12px; padding: 16px 20px; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666; font-size: 14px;">Total Recipients</span>
                    <span style="font-weight: 600; color: #1a1a2e;">{{ number_format($campaign['sent']) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666; font-size: 14px;"><span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #28a745; margin-right: 8px;"></span> Opened</span>
                    <span style="font-weight: 600; color: #28a745;">{{ number_format($campaign['opened']) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee;">
                    <span style="color: #666; font-size: 14px;"><span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #dc3545; margin-right: 8px;"></span> Unopened</span>
                    <span style="font-weight: 600; color: #dc3545;">{{ number_format($campaign['sent'] - $campaign['opened']) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                    <span style="color: #666; font-size: 14px;"><span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #ff9800; margin-right: 8px;"></span> Open Rate</span>
                    <span style="font-weight: 600; color: #ff9800;">{{ $openRate }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================
     QUICK ACTIONS
     ======================================== -->
<div class="detail-card">
    <div class="section-title"><i class="fas fa-bolt"></i> Quick Actions</div>
    <div class="d-flex gap-3 flex-wrap">
        <a href="{{ route('admin.marketing.edit', $campaign['id']) }}" class="btn-edit" style="padding: 10px 24px;">
            <i class="fas fa-edit"></i> Edit Campaign
        </a>
        <a href="{{ route('admin.marketing.index') }}" class="btn-back" style="padding: 10px 24px;">
            <i class="fas fa-arrow-left"></i> Back to Campaigns
        </a>
        <form action="{{ route('admin.marketing.toggle', $campaign['id']) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn-back" style="padding: 10px 24px; background: #0d6efd; color: #fff;">
                <i class="fas fa-sync"></i>
                @if($campaign['status'] == 'active')
                    Mark as Completed
                @else
                    Mark as Active
                @endif
            </button>
        </form>
    </div>
</div>
@endsection