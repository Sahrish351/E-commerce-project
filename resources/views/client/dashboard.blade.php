@extends('client.layouts.app')

@section('title', 'Overview')

@section('content')
<style>
    /* ========================================
       CLIENT DASHBOARD - WITH CHART
       ======================================== */
    :root {
        --bg-body: #f4f6f9;
        --bg-card: #ffffff;
        --text-primary: #1a1a2e;
        --text-secondary: #8c8c9c;
        --border-color: #f0f0f0;
        --shadow: 0 2px 15px rgba(0,0,0,0.04);
        --primary: #db4444;
    }
    [data-theme="dark"] {
        --bg-body: #0a0a15;
        --bg-card: #1a1a2e;
        --text-primary: #ffffff;
        --text-secondary: #94a3b8;
        --border-color: #2a2a44;
        --shadow: 0 2px 15px rgba(0,0,0,0.2);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 20px 22px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .stat-card .label {
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 4px;
    }
    .stat-card .value {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.2;
    }
    .stat-card .trend {
        font-size: 12px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 30px;
        display: inline-block;
        margin-top: 6px;
        background: #f0f0f0;
        color: #888;
    }
    .stat-card .icon-box {
        float: right;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .stat-card .icon-box.blue { background: rgba(79,172,254,0.12); color: #1976d2; }
    .stat-card .icon-box.green { background: rgba(67,233,123,0.12); color: #2e7d32; }
    .stat-card .icon-box.orange { background: rgba(245,87,108,0.12); color: #e65100; }
    .stat-card .icon-box.pink { background: rgba(219,68,68,0.12); color: #c62828; }
    [data-theme="dark"] .stat-card .icon-box.blue { background: #1a2a4a; color: #64b5f6; }
    [data-theme="dark"] .stat-card .icon-box.green { background: #1a3a2a; color: #66bb6a; }
    [data-theme="dark"] .stat-card .icon-box.orange { background: #3a2a1a; color: #ffa726; }
    [data-theme="dark"] .stat-card .icon-box.pink { background: #3a1a2a; color: #ef5350; }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .quick-stat {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 14px 18px;
        text-align: center;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow);
        transition: all 0.3s;
    }
    .quick-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .quick-stat .number {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
    }
    .quick-stat .label {
        font-size: 12px;
        color: var(--text-secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .quick-stat .change {
        font-size: 11px;
        font-weight: 600;
        color: #2e7d32;
    }

    .chart-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 18px;
        margin-bottom: 24px;
    }
    .chart-box {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 20px 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow);
    }
    .chart-box .box-title {
        font-weight: 700;
        font-size: 16px;
        color: var(--text-primary);
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .chart-box .box-title .filter-dropdown {
        position: relative;
        display: inline-block;
    }
    .chart-box .box-title .filter-dropdown select {
        appearance: none;
        -webkit-appearance: none;
        background: var(--bg-body);
        border: 1px solid var(--border-color);
        border-radius: 30px;
        padding: 4px 30px 4px 16px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        cursor: pointer;
        outline: none;
        transition: all 0.3s;
    }
    .chart-box .box-title .filter-dropdown select:hover {
        border-color: var(--primary);
    }
    .chart-box .box-title .filter-dropdown::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 12px;
        pointer-events: none;
    }
    .chart-box .box-title .view-all {
        font-size: 13px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    .chart-box .box-title .view-all:hover {
        text-decoration: underline;
    }

    .chart-container {
        height: 200px;
        position: relative;
        width: 100%;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .status-item:last-child { border-bottom: none; }
    .status-item .label {
        font-size: 14px;
        color: var(--text-primary);
        opacity: 0.8;
    }
    .status-item .value {
        font-weight: 600;
        font-size: 14px;
        color: var(--text-primary);
    }
    .status-item .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .status-item .dot.pending { background: #ffc107; }
    .status-item .dot.processing { background: #0d6efd; }
    .status-item .dot.shipped { background: #17a2b8; }
    .status-item .dot.delivered { background: #28a745; }
    .status-item .dot.cancelled { background: #dc3545; }

    .order-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s;
    }
    .order-item:last-child { border-bottom: none; }
    .order-item:hover { padding-left: 6px; }
    .order-item .order-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--bg-body);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 14px;
        flex-shrink: 0;
    }
    .order-item .order-info { flex: 1; }
    .order-item .order-id {
        font-weight: 600;
        font-size: 14px;
        color: var(--text-primary);
    }
    .order-item .order-date {
        font-size: 12px;
        color: var(--text-secondary);
    }
    .order-item .order-status {
        font-size: 12px;
        font-weight: 500;
        padding: 3px 14px;
        border-radius: 30px;
        text-transform: capitalize;
    }
    .order-item .order-status.pending { background: #fff3cd; color: #856404; }
    .order-item .order-status.processing { background: #cce5ff; color: #004085; }
    .order-item .order-status.shipped { background: #d4edda; color: #155724; }
    .order-item .order-status.delivered { background: #28a745; color: #fff; }
    .order-item .order-status.cancelled { background: #f8d7da; color: #721c24; }
    [data-theme="dark"] .order-item .order-status.pending { background: #3a3a1a; color: #ffd54f; }
    [data-theme="dark"] .order-item .order-status.processing { background: #1a2a4a; color: #64b5f6; }
    [data-theme="dark"] .order-item .order-status.shipped { background: #1a3a3a; color: #4dd0e1; }
    [data-theme="dark"] .order-item .order-status.delivered { background: #1a3a2a; color: #66bb6a; }
    [data-theme="dark"] .order-item .order-status.cancelled { background: #3a1a1a; color: #ef5350; }
    .order-item .order-amount {
        font-weight: 700;
        color: var(--primary);
        font-size: 14px;
    }

    .empty-state {
        text-align: center;
        padding: 30px 20px;
    }
    .empty-state i {
        font-size: 40px;
        color: var(--text-secondary);
        opacity: 0.3;
        display: block;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: var(--text-secondary);
        font-size: 14px;
        margin: 0;
    }
    .empty-state .btn-shop {
        display: inline-block;
        margin-top: 12px;
        background: var(--primary);
        color: #fff;
        padding: 8px 28px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .empty-state .btn-shop:hover {
        background: #b33232;
        transform: translateY(-2px);
        color: #fff;
    }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .quick-stats { grid-template-columns: repeat(2, 1fr); }
        .chart-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-grid { gap: 12px; }
        .stat-card { padding: 14px 16px; }
        .stat-card .value { font-size: 20px; }
        .stat-card .icon-box { width: 40px; height: 40px; font-size: 16px; }
        .quick-stats { gap: 10px; }
        .quick-stat { padding: 10px 14px; }
        .quick-stat .number { font-size: 17px; }
        .chart-box { padding: 14px 16px; }
        .chart-container { height: 160px; }
        .order-item { flex-wrap: wrap; gap: 6px; }
        .order-item .order-amount { margin-left: auto; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
        .stat-card { padding: 10px 12px; }
        .stat-card .value { font-size: 16px; }
        .stat-card .label { font-size: 11px; }
        .stat-card .icon-box { width: 32px; height: 32px; font-size: 14px; }
        .quick-stats { grid-template-columns: 1fr 1fr; }
        .quick-stat { padding: 8px 10px; }
        .quick-stat .number { font-size: 15px; }
        .chart-box { padding: 10px 12px; }
        .chart-container { height: 140px; }
        .chart-box .box-title { font-size: 14px; }
    }
</style>

<!-- ========================================
     STATS CARDS
     ======================================== -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon-box blue"><i class="fas fa-shopping-bag"></i></div>
        <div class="label">Total Orders</div>
        <div class="value">{{ $orderStats['total'] ?? 0 }}</div>
        <span class="trend">● Lifetime</span>
    </div>
    <div class="stat-card">
        <div class="icon-box orange"><i class="fas fa-clock"></i></div>
        <div class="label">Pending Orders</div>
        <div class="value">{{ $orderStats['pending'] ?? 0 }}</div>
        <span class="trend">● In Progress</span>
    </div>
    <div class="stat-card">
        <div class="icon-box green"><i class="fas fa-check-circle"></i></div>
        <div class="label">Delivered</div>
        <div class="value">{{ $orderStats['delivered'] ?? 0 }}</div>
        <span class="trend">● Completed</span>
    </div>
    <div class="stat-card">
        <div class="icon-box pink"><i class="fas fa-heart"></i></div>
        <div class="label">Wishlist</div>
        <div class="value">{{ $wishlistCount ?? 0 }}</div>
        <span class="trend">● Saved Items</span>
    </div>
</div>

<!-- ========================================
     QUICK STATS
     ======================================== -->
<div class="quick-stats">
    <div class="quick-stat">
        <div class="number">{{ $orderStats['pending'] ?? 0 }}</div>
        <div class="label">Pending</div>
        <div class="change">↑ 0%</div>
    </div>
    <div class="quick-stat">
        <div class="number">{{ $orderStats['processing'] ?? 0 }}</div>
        <div class="label">Processing</div>
        <div class="change">↑ 0%</div>
    </div>
    <div class="quick-stat">
        <div class="number">{{ $orderStats['shipped'] ?? 0 }}</div>
        <div class="label">Shipped</div>
        <div class="change">↑ 0%</div>
    </div>
    <div class="quick-stat">
        <div class="number">{{ $orderStats['delivered'] ?? 0 }}</div>
        <div class="label">Delivered</div>
        <div class="change">↑ 0%</div>
    </div>
</div>

<!-- ========================================
     CHART + ORDER STATUS
     ======================================== -->
<div class="chart-row">
    <div class="chart-box">
        <div class="box-title">
            Order Overview
            <div class="filter-dropdown">
                <select id="chartFilter" onchange="updateChart(this.value)">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <div class="chart-box">
        <div class="box-title">Order Status</div>
        <div class="status-item">
            <span class="label"><span class="dot pending"></span>Pending</span>
            <span class="value">{{ $orderStats['pending'] ?? 0 }}</span>
        </div>
        <div class="status-item">
            <span class="label"><span class="dot processing"></span>Processing</span>
            <span class="value">{{ $orderStats['processing'] ?? 0 }}</span>
        </div>
        <div class="status-item">
            <span class="label"><span class="dot shipped"></span>Shipped</span>
            <span class="value">{{ $orderStats['shipped'] ?? 0 }}</span>
        </div>
        <div class="status-item">
            <span class="label"><span class="dot delivered"></span>Delivered</span>
            <span class="value">{{ $orderStats['delivered'] ?? 0 }}</span>
        </div>
        <div class="status-item" style="border-bottom:none;">
            <span class="label"><span class="dot cancelled"></span>Cancelled</span>
            <span class="value">{{ $orderStats['cancelled'] ?? 0 }}</span>
        </div>
    </div>
</div>

<!-- ========================================
     RECENT ORDERS
     ======================================== -->
<div class="chart-box" style="margin-bottom:0;">
    <div class="box-title">
        Recent Orders
        <a href="{{ route('client.orders') }}" class="view-all">View All →</a>
    </div>

    @forelse($recentOrders ?? [] as $order)
    <a href="{{ route('client.orders.show', $order->id) }}" class="order-item">
        <div class="order-icon"><i class="fas fa-receipt"></i></div>
        <div class="order-info">
            <div class="order-id">#{{ $order->order_number ?? $order->id }}</div>
            <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
        </div>
        <span class="order-status {{ $order->status ?? 'pending' }}">
            {{ ucfirst($order->status ?? 'pending') }}
        </span>
        <span class="order-amount">${{ number_format($order->total_amount ?? $order->total ?? 0, 2) }}</span>
    </a>
    @empty
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p>You haven't placed any orders yet.</p>
        <a href="{{ route('shop.index') }}" class="btn-shop">
            <i class="fas fa-store me-2"></i> Start Shopping
        </a>
    </div>
    @endforelse
</div>

<!-- ========================================
     CHART SCRIPT - CDN LOAD
     ======================================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // ========================================
    // CHART DATA
    // ========================================
    var chartData = {
        daily: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            data: [
                {{ $dailyOrders['Mon'] ?? 0 }},
                {{ $dailyOrders['Tue'] ?? 0 }},
                {{ $dailyOrders['Wed'] ?? 0 }},
                {{ $dailyOrders['Thu'] ?? 0 }},
                {{ $dailyOrders['Fri'] ?? 0 }},
                {{ $dailyOrders['Sat'] ?? 0 }},
                {{ $dailyOrders['Sun'] ?? 0 }}
            ]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            data: [
                {{ $weeklyOrders[1] ?? 0 }},
                {{ $weeklyOrders[2] ?? 0 }},
                {{ $weeklyOrders[3] ?? 0 }},
                {{ $weeklyOrders[4] ?? 0 }}
            ]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            data: [
                {{ $monthlyOrders['Jan'] ?? 0 }},
                {{ $monthlyOrders['Feb'] ?? 0 }},
                {{ $monthlyOrders['Mar'] ?? 0 }},
                {{ $monthlyOrders['Apr'] ?? 0 }},
                {{ $monthlyOrders['May'] ?? 0 }},
                {{ $monthlyOrders['Jun'] ?? 0 }},
                {{ $monthlyOrders['Jul'] ?? 0 }},
                {{ $monthlyOrders['Aug'] ?? 0 }},
                {{ $monthlyOrders['Sep'] ?? 0 }},
                {{ $monthlyOrders['Oct'] ?? 0 }},
                {{ $monthlyOrders['Nov'] ?? 0 }},
                {{ $monthlyOrders['Dec'] ?? 0 }}
            ]
        },
        yearly: {
            labels: ['2020', '2021', '2022', '2023', '2024'],
            data: [
                {{ $yearlyOrders[2020] ?? 0 }},
                {{ $yearlyOrders[2021] ?? 0 }},
                {{ $yearlyOrders[2022] ?? 0 }},
                {{ $yearlyOrders[2023] ?? 0 }},
                {{ $yearlyOrders[2024] ?? 0 }}
            ]
        }
    };

    var orderChart = null;

    // ========================================
    // INIT CHART
    // ========================================
    function initChart() {
        var ctx = document.getElementById('orderChart');
        if (!ctx) {
            console.log('Canvas not found');
            return;
        }
        
        var ctx2d = ctx.getContext('2d');
        var data = chartData.monthly;
        
        orderChart = new Chart(ctx2d, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Orders',
                    data: data.data,
                    backgroundColor: '#db4444',
                    borderColor: '#db4444',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
        
        console.log('Chart initialized successfully');
    }

    // ========================================
    // UPDATE CHART
    // ========================================
    function updateChart(period) {
        var data = chartData[period];
        if (data && orderChart) {
            orderChart.data.labels = data.labels;
            orderChart.data.datasets[0].data = data.data;
            orderChart.update();
            console.log('Chart updated to: ' + period);
        } else {
            console.log('Chart update failed');
        }
    }

    // ========================================
    // DOM READY
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing chart...');
        // Small delay to ensure canvas is rendered
        setTimeout(function() {
            initChart();
        }, 100);
    });
    
    // Also run when window is fully loaded
    window.addEventListener('load', function() {
        if (!orderChart) {
            console.log('Re-initializing chart on load');
            initChart();
        }
    });
</script>
@endsection