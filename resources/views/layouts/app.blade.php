<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <style>
    /* Custom SweetAlert2 styling to match Bootstrap theme */
    .swal2-popup {
        border-radius: 0.5rem !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .swal2-title {
        color: #212529 !important;
        font-weight: 600 !important;
    }
    
    .swal2-content {
        color: #6c757d !important;
    }
    
    /* Fix success icon styling to match Bootstrap theme */
    .swal2-success {
        border-color: #198754 !important;
    }
    
    .swal2-success .swal2-success-ring {
        border-color: #198754 !important;
    }
    
    .swal2-error .swal2-error-x .swal2-error-line {
        background-color: #dc3545 !important;
    }
    
    .swal2-warning .swal2-warning-icon {
        border-color: #fd7e14 !important;
        color: #fd7e14 !important;
    }
    
    .swal2-question .swal2-question-mark {
        border-color: #0d6efd !important;
        color: #0d6efd !important;
    }
    </style>
    <style>
    .icon-size {
        width: 24px;
        height: 24px;
        color: white;
    }

    .sidebar {
        background: linear-gradient(135deg, #198754, #157347);
        color: white;
        height: 100vh;
        padding: 20px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        overflow-y: auto;
        width: 230px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 1050;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
    }

    .sidebar-subtitle {
        font-size: 0.875rem;
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
    }

    .sidebar .nav-link {
        color: white;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
        width: 100%;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(10px);
    }

    .sidebar .nav-link svg {
        margin-right: 10px;
        flex-shrink: 0;
    }

    .main-content {
        padding: 40px;
        margin-left: 230px;
        transition: margin-left 0.3s;
    }

    .header {
        position: fixed;
        top: 0;
        left: 230px;
        right: 0;
        background-color: white;
        z-index: 1000;
        padding: 20px;
        border-bottom: 1px solid #ddd;
        transition: left 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        height: 80px;
    }

    .content {
        margin-top: 120px;
        min-height: calc(100vh - 120px);
    }

    .logo {
        width: 50px;
        height: 50px;
    }

    .btn-tambah {
        background-color: #198754;
        color: white;
        border: none;
    }

    .btn-tambah:hover {
        background-color: #157347;
        color: white;
    }

    .sidebar .d-flex {
        align-items: center;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin-bottom: 20px;
    }

    /* Mobile sidebar toggle button */
    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 12px;
        left: 12px;
        z-index: 9999;
        background: #198754;
        border: none;
        color: white;
        border-radius: 6px;
        padding: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
        /* Ensure button is always clickable */
        pointer-events: auto !important;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        /* Smooth visibility transitions */
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .sidebar-toggle:hover,
    .sidebar-toggle:focus,
    .sidebar-toggle:active {
        background: #157347;
        color: white;
        outline: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: translateY(-1px);
    }

    .sidebar-toggle:active {
        transform: translateY(0);
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .sidebar-toggle i {
        pointer-events: none;
    }

    /* Overlay for mobile sidebar */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display: flex;
        }

        /* Hide the toggle button when sidebar is open */
        .sidebar-toggle.hidden {
            opacity: 0;
            pointer-events: none;
            transform: scale(0.8);
            visibility: hidden;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .main-content {
            margin-left: 0;
            padding: 20px 15px;
        }

        .header {
            left: 0;
            padding: 8px 12px;
            height: auto;
            min-height: 60px;
        }

        .header .d-flex {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 0.25rem;
            flex-wrap: nowrap;
        }

        .header h4 {
            display: none !important;
        }

        .header .d-flex.align-items-center {
            flex-shrink: 0;
            gap: 0.15rem;
            margin-left: auto;
        }

        .header .dropdown-toggle {
            padding: 0.2rem;
            font-size: 0;
            border: none;
            background: transparent !important;
        }

        .header .dropdown-toggle span {
            display: none !important;
        }

        .header .bg-success.rounded-circle {
            width: 32px !important;
            height: 32px !important;
            flex-shrink: 0;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .header .bg-success.rounded-circle i {
            font-size: 0.9rem;
        }

        .content {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        .logo {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
        }

        /* Profile dropdown adjustments */
        .dropdown-menu {
            min-width: 200px;
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
        }
        
        /* Fix button interactions on mobile */
        .btn,
        .dropdown-toggle {
            touch-action: manipulation;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        }
        
        /* Ensure proper touch targets */
        .nav-link {
            min-height: 48px;
            display: flex;
            align-items: center;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            padding: 15px 10px;
        }

        .header {
            padding: 8px 12px;
            min-height: 55px;
        }

        .header h4 {
            display: none !important;
        }

        .header .dropdown-toggle {
            padding: 0.2rem 0.4rem;
            font-size: 0.8rem;
        }

        .header .dropdown-toggle span {
            display: none;
        }

        .header .bg-success.rounded-circle {
            width: 28px !important;
            height: 28px !important;
        }

        .header .bg-success.rounded-circle i {
            font-size: 0.8rem;
        }

        .logo {
            width: 30px;
            height: 30px;
        }

        .content {
            margin-top: 75px;
            min-height: calc(100vh - 75px);
        }

        .sidebar {
            width: 260px;
        }

        .sidebar-title {
            font-size: 1.1rem;
        }

        .sidebar-subtitle {
            font-size: 0.8rem;
        }

        .sidebar .nav-link {
            padding: 8px;
            font-size: 0.9rem;
        }

        .icon-size {
            width: 20px;
            height: 20px;
        }

        .logo {
            width: 35px;
            height: 35px;
        }
    }

    /* Ensure content is never hidden behind sidebar */
    @media (min-width: 769px) {
        .sidebar {
            transform: translateX(0) !important;
        }
    }

    /* Profile Dropdown Styles */
    .dropdown-toggle:after {
        border: none;
        content: "";
        display: inline-block;
        font-family: "bootstrap-icons";
        font-size: 12px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        min-width: 250px;
    }

    .dropdown-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 12px 20px;
    }

    .dropdown-item {
        padding: 10px 20px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #198754;
        color: white;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    /* Touch device optimizations */
    .touch-device .btn,
    .touch-device .nav-link,
    .touch-device .dropdown-toggle {
        min-height: 44px;
        padding: 0.5rem 1rem;
    }

    .touch-device .btn-sm {
        min-height: 36px;
        padding: 0.25rem 0.5rem;
    }

    /* DataTables mobile optimizations */
    @media (max-width: 768px) {
        .dataTables_wrapper {
            font-size: 0.8rem;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control {
            position: relative;
            padding-left: 30px;
        }
        
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before {
            top: 50%;
            left: 5px;
            height: 1em;
            width: 1em;
            margin-top: -0.5em;
            display: block;
            position: absolute;
            color: white;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1em;
            content: '+';
            background-color: #31b131;
        }
    }        /* Extra small devices optimization */
        @media (max-width: 576px) {
            .header h4 {
                font-size: 0.8rem;
                max-width: calc(100vw - 100px);
                margin-left: 25px;
            }
            
            .header .dropdown-toggle {
                padding: 0.15rem;
                font-size: 0;
            }
            
            .header .bg-success.rounded-circle {
                width: 26px !important;
                height: 26px !important;
            }
            
            .header .bg-success.rounded-circle i {
                font-size: 0.75rem;
            }
            
            .logo {
                width: 28px;
                height: 28px;
            }
            
            .header {
                padding: 6px 10px;
                min-height: 50px;
            }
            
            .content {
                margin-top: 65px;
                min-height: calc(100vh - 65px);
            }
        }        /* Landscape mobile optimization */
        @media (max-width: 768px) and (orientation: landscape) {
            .header {
                min-height: 45px;
                padding: 4px 12px;
            }
            
            .header h4 {
                font-size: 0.75rem;
                margin-left: 20px;
                max-width: calc(100vw - 90px);
            }
            
            .header .bg-success.rounded-circle {
                width: 24px !important;
                height: 24px !important;
            }
            
            .header .bg-success.rounded-circle i {
                font-size: 0.7rem;
            }
            
            .logo {
                width: 26px;
                height: 26px;
            }
            
            .content {
                margin-top: 55px;
                min-height: calc(100vh - 55px);
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
    <!-- Mobile Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleMobileSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar" id="sidebar">
                <div class="d-flex flex-column align-items-center justify-content-center p-3">
                    <img src="{{ asset('img/BPDLogo.png') }}" alt="KPSI Logo" class="logo mb-2">
                    <h3 class="sidebar-title mb-0">KPSI</h3>
                    <p class="sidebar-subtitle mb-0">Katalog Perubahan Sistem Informasi</p>
                </div>
                <hr class="w-100 my-3" style="border-color: rgba(255, 255, 255, 0.3);">
                <ul class="nav flex-column mt-4 w-100">
                    <li class="nav-item mb-2">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="icon-size me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    @can('view-applications')
                    <li class="nav-item mb-2">
                        <a href="{{ route('applications.index') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="icon-size me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Aplikasi
                        </a>
                    </li>
                    @endcan
                    @can('view-changes')
                    <li class="nav-item">
                        <a href="{{ route('changes.index') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="icon-size me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Perubahan
                        </a>
                    </li>
                    @endcan
                    
                    @if(auth()->user()->can('view-users') || auth()->user()->can('view-roles') || auth()->user()->can('view-permissions'))
                    <!-- Role & Permission Management -->
                    <li class="nav-item mt-3 mb-2">
                        <hr class="w-100 my-2" style="border-color: rgba(255, 255, 255, 0.3);">
                        <h6 class="sidebar-subtitle px-3 mb-2" style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.7); text-transform: uppercase; letter-spacing: 1px;">
                            User Management
                        </h6>
                    </li>
                    @can('view-users')
                    <li class="nav-item mb-2">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="bi bi-people icon-size me-2"></i>
                            Users
                        </a>
                    </li>
                    @endcan
                    @can('view-roles')
                    <li class="nav-item mb-2">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="bi bi-shield-check icon-size me-2"></i>
                            Roles
                        </a>
                    </li>
                    @endcan
                    @can('view-permissions')
                    <li class="nav-item mb-2">
                        <a href="{{ route('permissions.index') }}" class="nav-link">
                            <i class="bi bi-key icon-size me-2"></i>
                            Permissions
                        </a>
                    </li>
                    @endcan
                    @endif
                    
                    @auth
                    <li class="nav-item mt-3">
                        <hr class="w-100 my-2" style="border-color: rgba(255, 255, 255, 0.3);">
                        <a href="{{ route('profile.edit') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="icon-size me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4 main-content">
                <div class="header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title">@yield('header-title', 'KATALOG PERUBAHAN SISTEM APLIKASI')</h4>
                    <div class="d-flex align-items-center">
                        <!-- User Profile Dropdown -->
                        @auth
                        <div class="dropdown me-3">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" 
                                    id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-success rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                     style="width: 35px; height: 35px;">
                                    <i class="bi bi-person-fill text-white"></i>
                                </div>
                                <span class="me-1">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li class="dropdown-header">
                                    <div class="d-flex flex-column">
                                        <strong>{{ Auth::user()->name }}</strong>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                        <img src="{{ asset('img/BPDLogo.png') }}" alt="Bank BPD Bali Logo" class="logo">
                    </div>
                </div>
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
    // Pure JavaScript fallback function for mobile sidebar toggle
    function toggleMobileSidebar() {
        console.log('toggleMobileSidebar called');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        if (sidebar && overlay && toggleBtn) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            
            // Hide/show the toggle button with proper transitions
            if (sidebar.classList.contains('show')) {
                toggleBtn.classList.add('hidden');
                console.log('Button hidden - sidebar is now open');
            } else {
                toggleBtn.classList.remove('hidden');
                console.log('Button shown - sidebar is now closed');
            }
            
            console.log('Sidebar toggled via fallback function');
        } else {
            console.error('Sidebar or overlay elements not found');
        }
    }

    // Function to close mobile sidebar
    function closeMobileSidebar() {
        console.log('closeMobileSidebar called');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        if (sidebar && overlay && toggleBtn) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            toggleBtn.classList.remove('hidden');
            console.log('Sidebar closed via fallback function - button restored');
        }
    }

    // Additional initialization when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        
        // Ensure mobile button is working on all devices
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            console.log('Mobile toggle button found in DOM');
            
            // Add event listener using both approaches for maximum compatibility
            toggleBtn.onclick = function(e) {
                e.preventDefault();
                toggleMobileSidebar();
            };
            
            // Also add touch events for mobile
            toggleBtn.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMobileSidebar();
            }, {passive: false});
        }
    });

    // Global SweetAlert2 configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Global SweetAlert2 defaults - set without firing
    Swal.setDefaults({
        customClass: {
            confirmButton: 'btn btn-success mx-2',
            cancelButton: 'btn btn-secondary mx-2'
        },
        buttonsStyling: false
    });

    // Mobile Sidebar Toggle Functionality
    $(document).ready(function() {
        const sidebar = $('#sidebar');
        const sidebarToggle = $('#sidebarToggle');
        const sidebarOverlay = $('#sidebarOverlay');
        let isTouch = false;

        // Debug: Log when button is found
        console.log('Sidebar toggle button found:', sidebarToggle.length > 0);
        console.log('Window width:', $(window).width());

        // Detect touch device
        function isTouchDevice() {
            return 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
        }

        // Function to toggle sidebar
        function toggleSidebar() {
            console.log('Toggling sidebar via jQuery');
            sidebar.toggleClass('show');
            sidebarOverlay.toggleClass('show');
            
            // Hide/show the toggle button with proper logging
            if (sidebar.hasClass('show')) {
                sidebarToggle.addClass('hidden');
                console.log('jQuery: Button hidden - sidebar is now open');
            } else {
                sidebarToggle.removeClass('hidden');
                console.log('jQuery: Button shown - sidebar is now closed');
            }
        }

        // Handle touch start
        sidebarToggle.on('touchstart', function(e) {
            console.log('Touch start detected');
            isTouch = true;
            e.preventDefault();
        });

        // Handle touch end
        sidebarToggle.on('touchend', function(e) {
            console.log('Touch end detected');
            e.preventDefault();
            e.stopPropagation();
            if (isTouch) {
                toggleSidebar();
                isTouch = false;
            }
        });

        // Handle click for non-touch devices
        sidebarToggle.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Click detected, isTouch:', isTouch);
            
            // Only handle click if it's not a touch device or touch didn't fire
            if (!isTouchDevice() || !isTouch) {
                toggleSidebar();
            }
            isTouch = false;
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.on('click touchend', function(e) {
            e.preventDefault();
            console.log('Overlay clicked/touched - closing sidebar');
            sidebar.removeClass('show');
            sidebarOverlay.removeClass('show');
            sidebarToggle.removeClass('hidden');
            console.log('jQuery: Button restored after overlay click');
        });

        // Close sidebar when clicking outside on mobile
        $(document).on('click touchstart', function(e) {
            if ($(window).width() <= 768) {
                if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && 
                    !sidebarToggle.is(e.target) && sidebarToggle.has(e.target).length === 0) {
                    sidebar.removeClass('show');
                    sidebarOverlay.removeClass('show');
                    sidebarToggle.removeClass('hidden');
                    console.log('jQuery: Button restored after outside click');
                }
            }
        });

        // Handle window resize
        $(window).resize(function() {
            if ($(window).width() > 768) {
                sidebar.removeClass('show');
                sidebarOverlay.removeClass('show');
                sidebarToggle.removeClass('hidden');
                console.log('jQuery: Button restored after window resize to desktop');
            }
        });

        // Add touch-friendly classes for mobile devices
        if (isTouchDevice()) {
            $('body').addClass('touch-device');
            console.log('Touch device detected');
        }

        // Add simple backup event handler for mobile devices
        if (window.innerWidth <= 768) {
            console.log('Mobile screen detected');
            
            // Add additional click handler for mobile using DOM
            const toggleButton = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (toggleButton && sidebar && overlay) {
                // Remove any existing event listeners to avoid conflicts
                toggleButton.onclick = null;
                
                // Add clean event listener
                toggleButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Direct DOM click handler triggered');
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                    
                    // Hide/show toggle button with logging
                    if (sidebar.classList.contains('show')) {
                        toggleButton.classList.add('hidden');
                        console.log('DOM: Button hidden - sidebar opened');
                    } else {
                        toggleButton.classList.remove('hidden');
                        console.log('DOM: Button shown - sidebar closed');
                    }
                }, {passive: false});
                
                // Also ensure overlay click works
                overlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Direct DOM overlay click - closing sidebar');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    toggleButton.classList.remove('hidden');
                    console.log('DOM: Button restored after overlay click');
                }, {passive: false});
            }
        }
    });

    </script>
    <script>
    tippy('[data-tippy-content]', {
        placement: 'bottom',
        animation: 'shift-away',
        theme: 'light',
    });
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    @stack('scripts')
</body>

</html>