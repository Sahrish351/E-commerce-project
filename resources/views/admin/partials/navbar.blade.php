<nav class="admin-navbar">
    <div class="navbar-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="page-title">@yield('page-title', 'Dashboard')</h5>
    </div>

    <div class="navbar-right">
        <!-- Search -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..." />
        </div>

        <!-- Notifications -->
        <div class="dropdown">
            <button class="icon-btn" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="badge">0</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-circle text-success me-2" style="font-size: 8px;"></i> New order received
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i> Product low in stock
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="#">View all</a></li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="dropdown user-dropdown">
            <button class="user-btn" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <!-- ✅ My Profile - Working Link -->
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="fas fa-user me-2"></i> My Profile
                    </a>
                </li>
                <!-- ✅ Settings - Working Link -->
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <!-- ✅ View Store -->
                <li>
                    <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-store me-2"></i> View Store
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <!-- ✅ Logout -->
                <li>
                    <a class="dropdown-item text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* ========================================
       NAVBAR - NEXTADMIN STYLE
       ======================================== */
    .admin-navbar {
        background: #fff;
        padding: 12px 28px;
        border-bottom: 1px solid #f0f0f0;
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 70px;
    }

    /* ----- Left Side ----- */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .sidebar-toggle {
        background: transparent;
        border: none;
        font-size: 20px;
        color: #555;
        cursor: pointer;
        padding: 4px;
        display: none;
    }
    .sidebar-toggle:hover {
        color: #db4444;
    }
    .page-title {
        font-weight: 600;
        font-size: 18px;
        color: #1a1a2e;
        margin: 0;
    }

    /* ----- Right Side ----- */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* Search Box */
    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-box i {
        position: absolute;
        left: 14px;
        color: #999;
        font-size: 14px;
    }
    .search-box input {
        padding: 8px 14px 8px 40px;
        border: 1px solid #e8e8e8;
        border-radius: 30px;
        font-size: 14px;
        width: 220px;
        background: #f8f9fa;
        transition: all 0.3s;
        outline: none;
    }
    .search-box input:focus {
        width: 280px;
        border-color: #db4444;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(219,68,68,0.08);
    }

    /* Icon Button */
    .icon-btn {
        background: transparent;
        border: none;
        font-size: 18px;
        color: #555;
        cursor: pointer;
        padding: 4px;
        position: relative;
        transition: all 0.3s;
    }
    .icon-btn:hover {
        color: #db4444;
    }
    .icon-btn .badge {
        position: absolute;
        top: -4px;
        right: -6px;
        background: #db4444;
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 30px;
        min-width: 18px;
        text-align: center;
    }

    /* User Dropdown */
    .user-btn {
        background: transparent;
        border: none;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .user-btn:hover {
        background: #f5f5f5;
    }
    .user-btn .user-avatar {
        width: 38px;
        height: 38px;
        background: #db4444;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 16px;
    }
    .user-btn .user-info {
        text-align: left;
        line-height: 1.3;
    }
    .user-btn .user-name {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
    }
    .user-btn .user-role {
        display: block;
        font-size: 11px;
        color: #999;
    }
    .user-btn i {
        color: #999;
        font-size: 12px;
        margin-left: 4px;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border-radius: 12px;
        padding: 8px 0;
        min-width: 220px;
        margin-top: 8px;
    }
    .dropdown-menu .dropdown-item {
        padding: 8px 18px;
        font-size: 14px;
        color: #333;
        transition: all 0.2s;
    }
    .dropdown-menu .dropdown-item:hover {
        background: #f8f9fa;
        color: #db4444;
    }
    .dropdown-menu .dropdown-item i {
        width: 18px;
        text-align: center;
        color: #999;
    }
    .dropdown-menu .dropdown-item:hover i {
        color: #db4444;
    }

    /* ----- Responsive ----- */
    @media (max-width: 992px) {
        .sidebar-toggle {
            display: block;
        }
        .search-box input {
            width: 160px;
        }
        .search-box input:focus {
            width: 200px;
        }
        .user-btn .user-info {
            display: none;
        }
        .user-btn i.fa-chevron-down {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .admin-navbar {
            padding: 10px 16px;
        }
        .search-box {
            display: none;
        }
        .page-title {
            font-size: 16px;
        }
    }
</style>

<script>
    // Sidebar Toggle for Mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar')?.classList.toggle('show');
    });
</script>