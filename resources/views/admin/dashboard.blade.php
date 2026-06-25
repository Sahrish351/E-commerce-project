@extends('admin.layouts.app')

@section('title', 'Dashboard - StyleHub Admin')

@section('content')
<style>
   
    .dashboard-section {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .stat-card .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-card .number {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .stat-card .label {
        font-size: 14px;
        color: #8c8c9c;
        font-weight: 500;
    }
    .stat-card .trend {
        font-size: 12px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .stat-card .trend.up { background: #e8f5e9; color: #2e7d32; }
    .stat-card .trend.down { background: #fbe9e7; color: #c62828; }
    .stat-card .trend.neutral { background: #f0f0f0; color: #888; }

    .stat-card.blue .icon-wrapper { background: rgba(79,172,254,0.12); color: #1976d2; }
    .stat-card.green .icon-wrapper { background: rgba(67,233,123,0.12); color: #2e7d32; }
    .stat-card.purple .icon-wrapper { background: rgba(161,140,209,0.12); color: #6a1b9a; }
    .stat-card.orange .icon-wrapper { background: rgba(245,87,108,0.12); color: #e65100; }

  
    .chart-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        overflow: hidden;
        height: 100%;
    }
    .chart-card .card-header-custom {
        padding: 16px 22px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: transparent;
        flex-wrap: wrap;
        gap: 10px;
    }
    .chart-card .card-header-custom .title {
        font-weight: 600;
        font-size: 15px;
        color: #1a1a2e;
    }
    .chart-card .card-header-custom .title i { color: #db4444; margin-right: 8px; }

   
    .filter-dropdown {
        position: relative;
        display: inline-block;
    }
    .filter-dropdown .filter-select {
        appearance: none;
        -webkit-appearance: none;
        background: #f0f0f0;
        border: none;
        padding: 6px 32px 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        outline: none;
        transition: all 0.3s;
        font-family: 'Inter', sans-serif;
        min-width: 100px;
        text-align: center;
    }
    .filter-dropdown .filter-select:hover {
        background: #e5e5e5;
    }
    .filter-dropdown .filter-select:focus {
        background: #fff;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.1);
    }
    .filter-dropdown::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 12px;
        pointer-events: none;
    }

    .chart-card .card-body-custom { padding: 18px 22px; }

 
    .chart-container { position: relative; height: 280px; width: 100%; }
    .chart-container-sm { position: relative; height: 220px; width: 100%; }

   
    .quick-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    .quick-stat-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 14px 18px;
        text-align: center;
        border: 1px solid #f0f0f0;
        transition: all 0.3s;
    }
    .quick-stat-item:hover {
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }
    .quick-stat-item .value {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
    }
    .quick-stat-item .label {
        font-size: 12px;
        color: #8c8c9c;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .quick-stat-item .change {
        font-size: 11px;
        font-weight: 600;
    }
    .quick-stat-item .change.up { color: #2e7d32; }
    .quick-stat-item .change.down { color: #c62828; }

   
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
    .table-premium tbody tr:last-child td { border-bottom: none; }
    .table-premium tbody tr:hover { background: #fafafa; }

    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
    }
    .badge-status.pending { background: #fff3cd; color: #856404; }
    .badge-status.processing { background: #cce5ff; color: #004085; }
    .badge-status.shipped { background: #d4edda; color: #155724; }
    .badge-status.delivered { background: #28a745; color: #fff; }
    .badge-status.cancelled { background: #f8d7da; color: #721c24; }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }
    .quick-actions-grid .action-btn {
        background: #f8f9fa;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 14px 10px;
        text-align: center;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
        font-size: 13px;
        font-weight: 500;
    }
    .quick-actions-grid .action-btn:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(219,68,68,0.15);
    }
    .quick-actions-grid .action-btn i { display: block; font-size: 20px; margin-bottom: 4px; }

   
    .status-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
    }
    .status-legend .item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #555;
    }
    .status-legend .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

  
    @media (max-width: 992px) {
        .quick-actions-grid { grid-template-columns: repeat(3, 1fr); }
        .quick-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
        .quick-stats-grid { grid-template-columns: repeat(2, 1fr); }
        .welcome-banner { padding: 20px; }
        .welcome-banner h2 { font-size: 20px; }
        .chart-card .card-header-custom { flex-direction: column; align-items: flex-start; }
        .filter-dropdown .filter-select { min-width: 80px; font-size: 12px; padding: 4px 28px 4px 12px; }
    }
</style>


<div class="row g-4 mb-4">
    
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">${{ number_format($totalSales ?? 0, 0) }}</div>
                    <div class="label">Total Revenue</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-dollar-sign"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend neutral"><i class="fas fa-minus"></i> 0%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>

   
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $totalOrders ?? 0 }}</div>
                    <div class="label">Total Orders</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-shopping-bag"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend neutral"><i class="fas fa-minus"></i> 0%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card purple">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $totalUsers ?? 0 }}</div>
                    <div class="label">Total Customers</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-users"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend neutral"><i class="fas fa-minus"></i> 0%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>

   
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $totalProducts ?? 0 }}</div>
                    <div class="label">Total Products</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-box"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend neutral"><i class="fas fa-minus"></i> 0%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>
</div>


<div class="quick-stats-grid mb-4">
    <div class="quick-stat-item">
        <div class="value">{{ $pendingOrders ?? 0 }}</div>
        <div class="label">Pending Orders</div>
        <div class="change up">↑ 0%</div>
    </div>
    <div class="quick-stat-item">
        <div class="value">{{ $processingOrders ?? 0 }}</div>
        <div class="label">Processing</div>
        <div class="change up">↑ 0%</div>
    </div>
    <div class="quick-stat-item">
        <div class="value">{{ $shippedOrders ?? 0 }}</div>
        <div class="label">Shipped</div>
        <div class="change up">↑ 0%</div>
    </div>
    <div class="quick-stat-item">
        <div class="value">{{ $deliveredOrders ?? 0 }}</div>
        <div class="label">Delivered</div>
        <div class="change up">↑ 0%</div>
    </div>
</div>


<div class="row g-4 mb-4">
  
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="card-header-custom">
                <span class="title"><i class="fas fa-chart-bar"></i> Payments Overview</span>
                <div class="filter-dropdown">
                    <select class="filter-select" id="paymentsFilter" onchange="updatePaymentsChart(this.value)">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="chart-container">
                    <canvas id="paymentsChart"></canvas>
                </div>
                <div class="status-legend mt-3">
                    <span class="item"><span class="dot" style="background: #db4444;"></span> Sales</span>
                    <span class="item"><span class="dot" style="background: #4facfe;"></span> Revenue</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <span class="title"><i class="fas fa-chart-line"></i> Profit This Week</span>
                <div class="filter-dropdown">
                    <select class="filter-select" id="profitFilter" onchange="updateProfitChart(this.value)">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="chart-container-sm">
                    <canvas id="profitChart"></canvas>
                </div>
                <div class="status-legend mt-2">
                    <span class="item"><span class="dot" style="background: #db4444;"></span> Sales</span>
                    <span class="item"><span class="dot" style="background: #4facfe;"></span> Revenue</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="quick-actions-grid mb-4">
    <a href="{{ route('admin.products.create') }}" class="action-btn">
        <i class="fas fa-plus-circle"></i> Add Product
    </a>
    <a href="{{ route('admin.orders.index') }}" class="action-btn">
        <i class="fas fa-eye"></i> View Orders
    </a>
    <a href="{{ route('admin.categories.create') }}" class="action-btn">
        <i class="fas fa-tag"></i> Add Category
    </a>
    <a href="{{ route('admin.coupons.create') }}" class="action-btn">
        <i class="fas fa-ticket"></i> Add Coupon
    </a>
    <a href="{{ route('admin.users.index') }}" class="action-btn">
        <i class="fas fa-users"></i> Manage Users
    </a>
    <a href="{{ route('shop.index') }}" target="_blank" class="action-btn">
        <i class="fas fa-store"></i> Visit Store
    </a>
</div>


<div class="row g-4">
    <div class="col-lg-12">
        <div class="chart-card">
            <div class="card-header-custom">
                <span class="title"><i class="fas fa-clock"></i> Recent Orders</span>
                <a href="{{ route('admin.orders.index') }}" class="link" style="color: #db4444; text-decoration: none; font-size: 13px; font-weight: 500;">
                    View All →
                </a>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td><strong>${{ number_format($order->total_amount ?? $order->grand_total ?? 0, 2) }}</strong></td>
                                <td>
                                    <span class="badge-status {{ $order->status ?? 'pending' }}">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td style="color: #999; font-size: 13px;">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px; border-color: #ddd;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                    No orders yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    var chartData = {
        daily: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            sales: [12, 19, 15, 22, 28, 24, 30],
            revenue: [8, 14, 10, 18, 22, 20, 25]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            sales: [65, 80, 72, 95],
            revenue: [45, 60, 55, 75]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            sales: [10, 15, 20, 18, 25, 30, 22, 28, 35, 40, 32, 38],
            revenue: [5, 8, 12, 10, 18, 22, 15, 20, 28, 32, 25, 30]
        },
        yearly: {
            labels: ['2020', '2021', '2022', '2023', '2024'],
            sales: [120, 180, 220, 280, 350],
            revenue: [80, 120, 160, 200, 280]
        }
    };

    var profitData = {
        daily: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            sales: [8, 12, 10, 15, 18, 14, 20],
            revenue: [5, 8, 6, 10, 12, 10, 15]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            sales: [45, 55, 50, 65],
            revenue: [30, 38, 35, 45]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            sales: [30, 45, 40, 55, 60, 50, 65, 70, 55, 80, 75, 90],
            revenue: [20, 30, 25, 38, 42, 35, 45, 50, 38, 55, 50, 65]
        }
    };

   
    var paymentsChart = null;
    var profitChart = null;

    function initCharts() {
        
        const ctx1 = document.getElementById('paymentsChart').getContext('2d');
        var data = chartData.monthly;
        paymentsChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Sales',
                        data: data.sales,
                        backgroundColor: '#db4444',
                        borderRadius: 4,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Revenue',
                        data: data.revenue,
                        backgroundColor: '#4facfe',
                        borderRadius: 4,
                        barPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });

      
        const ctx2 = document.getElementById('profitChart').getContext('2d');
        var pData = profitData.daily;
        profitChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: pData.labels,
                datasets: [
                    {
                        label: 'Sales',
                        data: pData.sales,
                        borderColor: '#db4444',
                        backgroundColor: 'rgba(219, 68, 68, 0.08)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#db4444',
                        pointRadius: 3
                    },
                    {
                        label: 'Revenue',
                        data: pData.revenue,
                        borderColor: '#4facfe',
                        backgroundColor: 'rgba(79, 172, 254, 0.08)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#4facfe',
                        pointRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    }

    
    function updatePaymentsChart(period) {
        var data = chartData[period];
        if (data && paymentsChart) {
            paymentsChart.data.labels = data.labels;
            paymentsChart.data.datasets[0].data = data.sales;
            paymentsChart.data.datasets[1].data = data.revenue;
            paymentsChart.update();
        }
    }

    
    function updateProfitChart(period) {
        var data = profitData[period];
        if (data && profitChart) {
            profitChart.data.labels = data.labels;
            profitChart.data.datasets[0].data = data.sales;
            profitChart.data.datasets[1].data = data.revenue;
            profitChart.update();
        }
    }

  
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
    });
</script>
@endsection