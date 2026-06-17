@extends('layouts.app')

@section('title', 'Admin Dashboard - E-Commerce Store')

@section('content')
<h1 class="mb-4">Admin Dashboard</h1>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <h2>{{ $totalOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <h2>${{ number_format($totalRevenue, 0) }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Management Links -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">📦 Products</h5>
                <p class="card-text">Manage product catalog</p>
                <a href="{{ route('admin.products') }}" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">📋 Orders</h5>
                <p class="card-text">View and manage orders</p>
                <a href="{{ route('admin.orders') }}" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">⭐ Reviews</h5>
                <p class="card-text">{{ $pendingReviews }} pending approval</p>
                <a href="{{ route('admin.reviews') }}" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">🏷️ Categories</h5>
                <p class="card-text">Manage categories</p>
                <a href="{{ route('admin.categories') }}" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
