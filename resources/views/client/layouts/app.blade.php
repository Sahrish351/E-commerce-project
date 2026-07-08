<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StyleHub - @yield('title', 'Dashboard')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
     
        :root {
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --bg-sidebar: #1a1a2e;
            --bg-topbar: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #8c8c9c;
            --text-muted: #aaa;
            --border-color: #f0f0f0;
            --shadow: 0 1px 8px rgba(0,0,0,0.04);
            --primary: #db4444;
            --primary-hover: #b33232;
            --sidebar-text: #cbd5e1;
            --sidebar-hover: #334155;
            --input-bg: #f8f9fa;
        }

        [data-theme="dark"] {
            --bg-body: #0a0a15;
            --bg-card: #1a1a2e;
            --bg-sidebar: #0a0a15;
            --bg-topbar: #1a1a2e;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #2a2a44;
            --shadow: 0 1px 8px rgba(0,0,0,0.3);
            --input-bg: #1a1a2e;
            --sidebar-text: #94a3b8;
            --sidebar-hover: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
  
        .content-wrapper {
            flex: 1;
            margin-left: 260px;
            padding: 0;
            background: var(--bg-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background 0.3s ease;
        }
        

        .topbar {
            background: var(--bg-topbar);
            padding: 10px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            min-height: 56px;
            width: 100%;
            flex-shrink: 0;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .topbar .left .sidebar-toggle {
            background: transparent;
            border: none;
            font-size: 18px;
            color: var(--text-primary);
            cursor: pointer;
            padding: 4px;
            display: none;
            transition: color 0.3s ease;
        }
        .topbar .left .sidebar-toggle:hover { color: var(--primary); }
        .topbar .left .welcome-text {
            font-weight: 600;
            font-size: 16px;
            color: var(--text-primary);
            margin: 0;
            transition: color 0.3s ease;
        }
        .topbar .left .welcome-text span {
            color: var(--primary);
            font-weight: 700;
        }
        .topbar .right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar .theme-toggle {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-primary);
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .topbar .theme-toggle:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(219, 68, 68, 0.05);
        }
        .topbar .theme-toggle span { display: none; }
        .topbar .user-profile {
            display: flex;
            align-items: center;
            gap: 0;
            cursor: pointer;
            padding: 3px;
            border-radius: 50%;
            transition: all 0.3s;
            background: transparent;
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: var(--text-primary);
            width: 32px;
            height: 32px;
            justify-content: center;
        }
        .topbar .user-profile:hover {
            border-color: var(--primary);
            background: rgba(219, 68, 68, 0.05);
        }
        .topbar .user-profile .avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 11px;
            flex-shrink: 0;
        }
        .topbar .user-profile .name,
        .topbar .user-profile .role,
        .topbar .user-profile .dropdown-icon {
            display: none;
        }

      
        .page-content {
            padding: 18px 24px 24px;
            flex: 1;
            background: var(--bg-body);
            transition: background 0.3s ease;
        }

   
        .sidebar {
            width: 260px;
            background: var(--bg-sidebar);
            color: #fff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: background 0.3s ease;
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
            color: #fff;
        }
        .sidebar .logo span { color: var(--primary); }
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
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            opacity: 0.7;
        }
        .sidebar ul li a:hover {
            background: var(--sidebar-hover);
            color: #fff;
            opacity: 1;
        }
        .sidebar ul li a.active {
            background: var(--primary);
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
            background: var(--primary);
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
            .content-wrapper {
                margin-left: 0;
            }
            .topbar {
                padding: 8px 14px;
                min-height: 48px;
            }
            .topbar .left .sidebar-toggle {
                display: block;
            }
            .topbar .left .welcome-text {
                font-size: 14px;
            }
            .topbar .theme-toggle {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }
            .topbar .user-profile {
                width: 28px;
                height: 28px;
            }
            .topbar .user-profile .avatar {
                width: 22px;
                height: 22px;
                font-size: 9px;
            }
            .page-content {
                padding: 12px 14px 14px;
            }
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
        @media (max-width: 480px) {
            .topbar .left .welcome-text {
                font-size: 12px;
            }
            .topbar .theme-toggle {
                width: 26px;
                height: 26px;
                font-size: 11px;
            }
            .topbar .user-profile {
                width: 26px;
                height: 26px;
            }
            .topbar .user-profile .avatar {
                width: 20px;
                height: 20px;
                font-size: 8px;
            }
            .page-content {
                padding: 8px 10px 10px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="main-wrapper">
        @include('client.partials.sidebar')
        <div class="content-wrapper">
       
            <header class="topbar">
                <div class="left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="welcome-text">
                        Welcome, <span>{{ Auth::user()->name }}</span>
                    </h5>
                </div>
                <div class="right">
                    <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                    <a href="{{ route('client.profile.edit') }}" class="user-profile" title="My Profile">
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    </a>
                </div>
            </header>

           
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('show');
            document.getElementById('sidebarOverlay')?.classList.toggle('show');
        });

     
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            
            const savedTheme = localStorage.getItem('clientTheme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
            }
            
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                if (currentTheme === 'dark') {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('clientTheme', 'light');
                    themeIcon.className = 'fas fa-moon';
                } else {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('clientTheme', 'dark');
                    themeIcon.className = 'fas fa-sun';
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>