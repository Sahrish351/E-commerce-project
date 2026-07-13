<!-- ========================================
     ADMIN SIDEBAR - COMPLETE
     ======================================== -->
<nav class="admin-sidebar" id="adminSidebar">
    
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-store"></i>
            <span>Style<span>Hub</span></span>
        </div>
        <small>Admin Dashboard</small>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        <p class="menu-label">MAIN MENU</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Customers
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket"></i> Coupons
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.wishlist.index') }}" class="nav-link {{ request()->routeIs('admin.wishlist.*') ? 'active' : '' }}">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>

        <p class="menu-label mt-4">FEATURES</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Analytics
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.marketing.index') }}" class="nav-link {{ request()->routeIs('admin.marketing.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Marketing
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.stocks.index') }}" class="nav-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Stocks
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" target="_blank" class="nav-link">
            <i class="fas fa-store-alt"></i> View Store
        </a>
        <a href="{{ route('logout') }}" class="nav-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>

<!-- ========================================
     TOGGLE BUTTON
     ======================================== -->
<button class="sidebar-toggle-btn" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- ========================================
     OVERLAY
     ======================================== -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ========================================
     CSS
     ======================================== -->
<style>
    .sidebar-header {
        padding: 24px 24px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
        background: #1a1a2e;
    }
    .sidebar-header .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
    }
    .sidebar-header .logo i {
        color: #db4444;
        font-size: 28px;
    }
    .sidebar-header .logo span span {
        color: #db4444;
    }
    .sidebar-header small {
        color: rgba(255,255,255,0.35);
        font-size: 12px;
        display: block;
        padding-left: 38px;
        margin-top: 2px;
    }

    .sidebar-menu {
        flex: 1;
        padding: 20px 16px 10px;
        overflow-y: auto;
    }
    .sidebar-menu .menu-label {
        color: rgba(255,255,255,0.25);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 0 12px;
        margin-bottom: 12px;
    }
    .sidebar-menu .nav-item {
        margin-bottom: 2px;
    }
    .sidebar-menu .nav-link {
        color: rgba(255,255,255,0.6) !important;
        padding: 10px 14px;
        border-radius: 8px;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }
    .sidebar-menu .nav-link i {
        width: 20px;
        font-size: 16px;
        text-align: center;
    }
    .sidebar-menu .nav-link:hover {
        background: rgba(255,255,255,0.06);
        color: #fff !important;
    }
    .sidebar-menu .nav-link.active {
        background: #db4444 !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(219,68,68,0.3);
    }

    .sidebar-footer {
        padding: 16px 16px 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
        background: #1a1a2e;
        margin-top: auto;
    }
    .sidebar-footer .nav-link {
        color: rgba(255,255,255,0.5) !important;
        padding: 10px 14px;
        border-radius: 8px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }
    .sidebar-footer .nav-link i {
        width: 20px;
        font-size: 16px;
        text-align: center;
    }
    .sidebar-footer .nav-link:hover {
        background: rgba(255,255,255,0.06);
        color: #fff !important;
    }
</style>