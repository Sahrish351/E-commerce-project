<!-- ========================================
     CLIENT SIDEBAR - ATTACHED WITH TOPBAR
     ======================================== -->
<style>
    .sidebar {
        width: 260px;
        background: #1a1a2e;
        color: #fff;
        padding: 20px 0;
        display: flex;
        flex-direction: column;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.3s ease;
        border-right: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
        top: 0;
        left: 0;
    }
    .sidebar .logo {
        font-size: 24px;
        font-weight: 700;
        padding: 0 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        margin-bottom: 8px;
    }
    .sidebar .logo span { color: #db4444; }
    .sidebar .logo small {
        display: block;
        font-size: 11px;
        font-weight: 400;
        color: #94a3b8;
        opacity: 0.6;
        margin-top: 2px;
    }
    .sidebar .menu-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        padding: 12px 24px 6px;
        font-weight: 600;
        opacity: 0.5;
    }
    .sidebar ul {
        list-style: none;
        padding: 0 10px;
        margin: 0;
    }
    .sidebar ul li {
        margin-bottom: 2px;
    }
    .sidebar ul li a {
        padding: 10px 16px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #cbd5e1;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        opacity: 0.7;
    }
    .sidebar ul li a:hover {
        background: #334155;
        color: #fff;
        opacity: 1;
    }
    .sidebar ul li a.active {
        background: #db4444;
        color: #fff;
        opacity: 1;
    }
    .sidebar ul li a i {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }
    .sidebar ul li a .badge {
        margin-left: auto;
        background: #db4444;
        color: #fff;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 30px;
    }
    .sidebar .divider {
        height: 1px;
        background: rgba(255,255,255,0.05);
        margin: 8px 20px;
    }
    .sidebar ul li a.logout:hover {
        background: rgba(219, 68, 68, 0.2);
        color: #ef5350 !important;
        opacity: 1;
    }

    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

    /* Mobile Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
    .sidebar-overlay.show { display: block; }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1050;
        }
        .sidebar.show { transform: translateX(0); }
        .sidebar-overlay.show { display: block; }
    }
</style>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="clientSidebar">
    <div class="logo">
        Style<span>Hub</span>
        <small>Client Dashboard</small>
    </div>

    <div class="menu-label">Main Menu</div>
    <ul>
        <li>
            <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Overview
            </a>
        </li>
        <li>
            <a href="{{ route('client.orders') }}" class="{{ request()->routeIs('client.orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> My Orders
                <span class="badge">{{ auth()->user()->orders()->count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('client.wishlist') }}" class="{{ request()->routeIs('client.wishlist') ? 'active' : '' }}">
                <i class="fas fa-heart"></i> Wishlist
            </a>
        </li>
        <li>
            <a href="{{ route('client.profile.edit') }}" class="{{ request()->routeIs('client.profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> My Profile
            </a>
        </li>
        <li>
            <a href="{{ route('client.profile.addresses') }}" class="{{ request()->routeIs('client.profile.addresses') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </a>
        </li>
    </ul>

    <div class="divider"></div>
    <div class="menu-label">Quick Links</div>
    <ul>
        <li>
            <a href="{{ route('shop.index') }}" target="_blank">
                <i class="fas fa-store"></i> Shop Now
            </a>
        </li>
        <li>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fas fa-home"></i> Visit Store
            </a>
        </li>
        <li>
            <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </li>
    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('clientSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    });
</script>