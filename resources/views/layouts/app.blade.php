<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
    </style>
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
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4 main-content">
                <div class="header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title">@yield('header-title', 'KATALOG PERUBAHAN SISTEM APLIKASI')</h4>
                    <img src="{{ asset('img/BPDLogo.png') }}" alt="Bank BPD Bali Logo" class="logo">
                </div>
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
    tippy('[data-tippy-content]', {
        placement: 'bottom',
        animation: 'shift-away',
        theme: 'light',
    });
    </script>
</body>

</html>