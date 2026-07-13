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
        body {
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .admin-wrapper {
            display: flex;
            height: 100vh;
        }
        .admin-content {
            flex: 1;
            height: 100vh;
            margin-left: 280px;
            transition: all 0.3s ease;
        }
        .admin-main {
            padding: 25px 30px;
        }
        
        @media (max-width: 992px) {
            .admin-content {
                margin-left: 0 !important;
            }
        }
        
        @media (max-width: 768px) {
            .admin-main {
                padding: 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar (includes toggle button and overlay) -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Navbar -->
            @include('admin.partials.navbar')

            <!-- Page Content -->
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- ===== SIDEBAR TOGGLE SCRIPT ===== -->
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