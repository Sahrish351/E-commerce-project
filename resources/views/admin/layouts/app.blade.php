<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - StyleHub')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #f4f6f9;
        }
        
        /* ========================================
           ADMIN WRAPPER
           ======================================== */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            height: 100%;
        }
        
        /* ========================================
           SIDEBAR - FULL HEIGHT
           ======================================== */
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
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
            z-index: 10;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        .admin-sidebar::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }

        /* ========================================
           CONTENT - FULL HEIGHT WITH SCROLL
           ======================================== */
        .admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 0px;
            transition: all 0.3s ease;
        }

        /* Navbar - Fixed at Top */
        .admin-navbar {
            position: sticky;
            top: 0;
            z-index: 9;
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border-bottom: 1px solid #f0f0f0;
            flex-shrink: 0;
        }

        /* Main Content - Scrollable */
        .admin-main {
            flex: 1;
            padding: 25px 30px;
            overflow-y: auto;
        }

        /* ========================================
           TOGGLE BUTTON
           ======================================== */
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

        /* ========================================
           OVERLAY
           ======================================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 992px) {
            .admin-content {
                margin-left: 0 !important;
            }
            
            .admin-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                width: 280px;
                height: 100vh !important;
                min-height: 100vh !important;
                max-height: 100vh !important;
                z-index: 1000;
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
            .admin-navbar {
                padding: 12px 15px;
            }
        }
        
        @media (max-width: 768px) {
            .admin-main {
                padding: 15px;
            }
            .admin-navbar {
                padding: 10px 15px;
            }
            .admin-navbar .page-title {
                font-size: 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        @include('admin.partials.sidebar')

        <div class="admin-content">
            <!-- Navbar -->
            <div class="admin-navbar">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="page-title mb-0 fw-bold">
                        <i class="fas fa-th-large me-2 text-danger"></i>
                        @yield('page-title', 'Dashboard')
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small d-none d-sm-block">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <div class="avatar-circle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: 600; font-size: 14px;">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('adminSidebar');
            var toggleBtn = document.getElementById('sidebarToggle');
            var overlay = document.getElementById('sidebarOverlay');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    if (overlay) {
                        overlay.classList.toggle('active');
                    }
                    var icon = this.querySelector('i');
                    if (icon) {
                        if (sidebar.classList.contains('open')) {
                            icon.className = 'fas fa-times';
                        } else {
                            icon.className = 'fas fa-bars';
                        }
                    }
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    var icon = toggleBtn.querySelector('i');
                    if (icon) {
                        icon.className = 'fas fa-bars';
                    }
                });
            }
            
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('open');
                    if (overlay) {
                        overlay.classList.remove('active');
                    }
                    var icon = toggleBtn.querySelector('i');
                    if (icon) {
                        icon.className = 'fas fa-bars';
                    }
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>