@extends('admin.layouts.app')

@section('title', 'Analytics - StyleHub Admin')

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
    .chart-card .card-header-custom .title i {
        color: #db4444;
        margin-right: 8px;
    }
    .chart-card .card-body-custom { padding: 18px 22px; }
    .chart-container { position: relative; height: 280px; width: 100%; }

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
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    .table-premium tbody tr:hover {
        background: #fafafa;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .chart-container {
            height: 200px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-chart-line"></i> Analytics</h4>
        <p>Track your store performance</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">$12,847</div>
                    <div class="label">Total Revenue</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-dollar-sign"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend up"><i class="fas fa-arrow-up"></i> 12.5%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">1,234</div>
                    <div class="label">Total Orders</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-shopping-bag"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend up"><i class="fas fa-arrow-up"></i> 8.2%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card purple">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">3,456</div>
                    <div class="label">Total Visitors</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-users"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend up"><i class="fas fa-arrow-up"></i> 5.7%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">2.5%</div>
                    <div class="label">Conversion Rate</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-percent"></i></div>
            </div>
            <div class="mt-2 d-flex align-items-center gap-3">
                <span class="trend down"><i class="fas fa-arrow-down"></i> 0.2%</span>
                <span style="font-size: 12px; color: #999;">vs last month</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="card-header-custom">
                <span class="title"><i class="fas fa-chart-area"></i> Revenue Overview</span>
                <div class="filter-dropdown">
                    <select class="filter-select">
                        <option>Monthly</option>
                        <option>Weekly</option>
                        <option>Yearly</option>
                    </select>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header-custom">
                <span class="title"><i class="fas fa-chart-pie"></i> Orders by Status</span>
            </div>
            <div class="card-body-custom">
                <div class="chart-container" style="height: 220px;">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="row g-2 mt-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ffc107;"></span>
                            <span style="font-size: 13px;">Pending</span>
                            <span class="ms-auto fw-bold">45</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #0dcaf0;"></span>
                            <span style="font-size: 13px;">Processing</span>
                            <span class="ms-auto fw-bold">32</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #0d6efd;"></span>
                            <span style="font-size: 13px;">Shipped</span>
                            <span class="ms-auto fw-bold">28</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #198754;"></span>
                            <span style="font-size: 13px;">Delivered</span>
                            <span class="ms-auto fw-bold">67</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #dc3545;"></span>
                            <span style="font-size: 13px;">Cancelled</span>
                            <span class="ms-auto fw-bold">12</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Products Table -->
<div class="chart-card">
    <div class="card-header-custom">
        <span class="title"><i class="fas fa-trophy"></i> Top Selling Products</span>
        <span style="font-size: 13px; color: #999;">Last 30 days</span>
    </div>
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Sold</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Nike Air Max Sports Shoes</td>
                        <td>Shoes</td>
                        <td>$120.00</td>
                        <td>45</td>
                        <td>$5,400</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Apple Watch Series 9</td>
                        <td>Watches</td>
                        <td>$399.00</td>
                        <td>28</td>
                        <td>$11,172</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Sony WF-1000XM5</td>
                        <td>Earbuds</td>
                        <td>$299.00</td>
                        <td>34</td>
                        <td>$10,166</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Ray-Ban Aviator Classic</td>
                        <td>Sunglasses</td>
                        <td>$149.00</td>
                        <td>22</td>
                        <td>$3,278</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Anker 20000mAh Power Bank</td>
                        <td>Power Banks</td>
                        <td>$79.00</td>
                        <td>56</td>
                        <td>$4,424</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const ctx1 = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [1200, 1800, 1500, 2200, 2800, 3200, 2500, 3000, 3800, 4200, 3500, 4000],
                    borderColor: '#db4444',
                    backgroundColor: 'rgba(219, 68, 68, 0.08)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#db4444',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
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

        // Status Chart
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: [45, 32, 28, 67, 12],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#0d6efd', '#198754', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection