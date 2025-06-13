<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    }

    .content {
        margin-top: 100px;
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

    /* DataTables Action Button Alignment Fix */
    .dataTables_wrapper .dataTable td {
        vertical-align: middle !important;
    }

    /* Action buttons container */
    .btn-group-actions {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
    }

    /* Mobile responsive action buttons */
    @media (max-width: 768px) {
        /* Action column specific styling */
        .dataTables_wrapper .dataTable td:last-child,
        .dataTables_wrapper .dataTable th:last-child {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 0.5rem 0.25rem !important;
        }
        
        /* Action buttons in mobile */
        .btn-action {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.7rem !important;
            margin: 0.1rem !important;
            min-width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
        }
        
        /* Button group for actions */
        .btn-group-actions {
            display: flex;
            gap: 0.2rem;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            max-width: 100px;
            margin: 0 auto;
        }
        
        /* Ensure buttons don't break layout */
        .btn-group-actions .btn {
            flex: 0 0 auto;
            white-space: nowrap;
        }
    }

    @media (max-width: 576px) {
        .btn-action {
            padding: 0.2rem 0.3rem !important;
            font-size: 0.65rem !important;
            min-width: 28px;
            height: 28px;
        }
        
        .btn-group-actions {
            gap: 0.1rem;
            max-width: 90px;
        }
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTable {
            font-size: 0.8rem;
        }
        
        .dataTables_wrapper .dataTable th,
        .dataTables_wrapper .dataTable td {
            padding: 0.5rem 0.25rem;
            word-wrap: break-word;
            max-width: 150px;
        }
        
        /* Action column specific */
        .dataTables_wrapper .dataTable td.text-center:last-child {
            position: sticky;
            right: 0;
            background: white;
            z-index: 1;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        }
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
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