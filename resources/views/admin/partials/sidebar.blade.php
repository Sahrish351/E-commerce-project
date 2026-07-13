<!-- ========================================
     ADMIN SIDEBAR - FULL HEIGHT FIXED
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
     CSS - FULL HEIGHT FIX
     ======================================== -->
<style>
    /* ===== SIDEBAR - FULL HEIGHT ===== */
    .admin-sidebar {
        width: 280px;
        background: #1a1a2e;
        flex-shrink: 0;
        position: sticky;
        top: 0;
        height: 100vh;
        min-height: 100vh;
        max-height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255,255,255,0.05);
        z-index: 100;
    }
    
    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #db4444;
        border-radius: 10px;
    }

    /* ===== SIDEBAR HEADER ===== */
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

    /* ===== SIDEBAR MENU ===== */
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

    /* ===== SIDEBAR FOOTER ===== */
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

    /* ===== TOGGLE BUTTON ===== */
    .sidebar-toggle-btn {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1001;
        background: #1a1a2e;
        color: #fff;
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        font-size: 20px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s;
        align-items: center;
        justify-content: center;
    }
    .sidebar-toggle-btn:hover {
        background: #db4444;
    }

    /* ===== OVERLAY ===== */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 99;
    }
    .sidebar-overlay.active {
        display: block;
    }

    /* ========================================
       RESPONSIVE - FULL HEIGHT
       ======================================== */
    @media (max-width: 992px) {
        .admin-sidebar {
            position: fixed;
            left: -280px;
            top: 0;
            width: 280px;
            height: 100vh !important;
            min-height: 100vh !important;
            max-height: 100vh !important;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .admin-sidebar.open {
            left: 0;
        }
        .sidebar-toggle-btn {
            display: flex;
        }
        .sidebar-overlay.active {
            display: block;
        }
        .admin-content {
            margin-left: 0 !important;
        }
        .sidebar-header {
            padding: 20px 20px 16px;
        }
        .sidebar-header .logo {
            font-size: 22px;
        }
        .sidebar-menu .nav-link {
            font-size: 13px;
            padding: 9px 12px;
        }
        .sidebar-footer .nav-link {
            font-size: 13px;
            padding: 9px 12px;
        }
    }

    @media (max-width: 576px) {
        .admin-sidebar {
            width: 260px;
            left: -260px;
            height: 100vh !important;
            min-height: 100vh !important;
            max-height: 100vh !important;
        }
        .sidebar-header {
            padding: 16px 16px 14px;
        }
        .sidebar-header .logo {
            font-size: 20px;
        }
        .sidebar-header .logo i {
            font-size: 22px;
        }
        .sidebar-header small {
            font-size: 11px;
            padding-left: 32px;
        }
        .sidebar-menu {
            padding: 15px 12px 8px;
        }
        .sidebar-menu .menu-label {
            font-size: 10px;
            padding: 0 10px;
        }
        .sidebar-menu .nav-link {
            font-size: 12px;
            padding: 8px 10px;
            gap: 10px;
        }
        .sidebar-menu .nav-link i {
            font-size: 14px;
            width: 18px;
        }
        .sidebar-footer {
            padding: 12px 12px 16px;
        }
        .sidebar-footer .nav-link {
            font-size: 12px;
            padding: 8px 10px;
            gap: 10px;
        }
        .sidebar-toggle-btn {
            width: 38px;
            height: 38px;
            font-size: 17px;
            top: 12px;
            left: 12px;
        }
    }

    @media (max-width: 400px) {
        .admin-sidebar {
            width: 240px;
            left: -240px;
            height: 100vh !important;
            
        }
        .sidebar-header .logo {
            font-size: 18px;
        }
        .sidebar-header .logo i {
            font-size: 20px;
        }
        .sidebar-header small {
            font-size: 10px;
            padding-left: 28px;
        }
        .sidebar-menu .nav-link {
            font-size: 11px;
            padding: 6px 8px;
            gap: 8px;
        }
        .sidebar-menu .nav-link i {
            font-size: 12px;
            width: 16px;
        }
        .sidebar-toggle-btn {
            width: 34px;
            height: 34px;
            font-size: 15px;
            top: 10px;
            left: 10px;
        }
    }
</style>