@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-title', 'Dashboard')

@push('styles')
<style>
    /* Enhanced Table Styling */
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .table-header {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .table-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.25rem;
    }
    
    .table-header .table-subtitle {
        opacity: 0.9;
        margin-top: 0.25rem;
        font-size: 0.9rem;
    }
    
    /* Enhanced DataTable Styling */
    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody td {
        border: none;
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Enhanced Badge Styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
        color: #212529 !important;
        box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e91e63 100%) !important;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
        box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        box-shadow: 0 2px 4px rgba(108, 117, 125, 0.3);
    }
    
    /* Enhanced Action Buttons */
    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        margin: 0 0.2rem;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .btn-action.btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
    }
    
    .btn-action.btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
    }
    
    .btn-action.btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: #212529;
    }
    
    .btn-action.btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e91e63 100%);
    }
    
    /* Enhanced Cards */
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card h3 {
        font-weight: 700;
        color: #2c3e50;
    }
    
    .card h6 {
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Icon Enhancements */
    .bg-success.bg-opacity-10,
    .bg-warning.bg-opacity-10,
    .bg-info.bg-opacity-10,
    .bg-primary.bg-opacity-10 {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
    }
    
    /* DataTables Enhancements */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        outline: none;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white !important;
        border-color: #198754;
        transform: translateY(-1px);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
        color: white !important;
        border-color: #198754 !important;
    }
    
    /* Mobile responsive adjustments for dashboard */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .table-header {
            padding: 1rem;
        }
        
        .table-header h5 {
            font-size: 1.1rem;
        }
        
        .table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.7rem;
        }
        
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .badge {
            font-size: 0.65rem;
            padding: 0.3rem 0.5rem;
        }
        
        .btn-action {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
            margin: 0.1rem;
        }
        
        /* Welcome card mobile adjustments */
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .d-flex.gap-2 {
            width: 100%;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-2 .btn,
        .d-flex.gap-2 form {
            flex: 1;
        }
        
        .d-flex.gap-2 .btn {
            width: 100%;
            text-align: center;
        }
        
        /* Statistics cards mobile layout */
        .row.mb-4 .col-md-3,
        .row.mb-4 .col-md-4 {
            margin-bottom: 1rem;
        }
        
        /* Table responsive adjustments */
        .table-responsive {
            margin: 0.5rem;
        }
        
        #changesTable {
            font-size: 0.8rem;
        }
        
        #changesTable th,
        #changesTable td {
            padding: 0.5rem 0.25rem;
        }
        
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
        
        h5.card-title {
            font-size: 1.1rem;
        }
        
        h5.mb-1 {
            font-size: 1.2rem;
        }
        
        h3.mb-0 {
            font-size: 1.8rem;
        }
        
        h6.text-muted {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        #changesTable {
            font-size: 0.7rem;
        }
        
        #changesTable th,
        #changesTable td {
            padding: 0.3rem 0.2rem;
        }
        
        .btn-sm {
            padding: 0.15rem 0.3rem;
            font-size: 0.65rem;
        }
        
        h5.card-title {
            font-size: 1rem;
        }
        
        h5.mb-1 {
            font-size: 1.1rem;
        }
        
        h3.mb-0 {
            font-size: 1.5rem;
        }
        
        h6.text-muted {
            font-size: 0.75rem;
        }
        
        /* Profile icon smaller */
        .bg-success.rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
        
        .bg-success.rounded-circle i {
            font-size: 1rem !important;
        }
    }
    
    /* Fix DataTables responsive behavior */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
            margin-top: 1rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .dataTables_wrapper .dataTables_paginate .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Welcome Card with Profile Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Selamat datang, {{ Auth::user()->name }}!</h5>
                                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                <small class="text-muted">
                                    Bergabung sejak {{ Auth::user()->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-person-gear me-1"></i>
                                Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Aplikasi</h6>
                            <h3 class="mb-0">{{ $totalApplications }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-window text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Perubahan</h6>
                            <h3 class="mb-0">{{ $totalChanges }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-gear text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Normal</h6>
                            <h3 class="mb-0">{{ $normalChanges }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Mendesak</h6>
                            <h3 class="mb-0">{{ $urgentChanges }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Status Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Menunggu Persetujuan</h6>
                            <h3 class="mb-0">{{ $pendingChanges }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Disetujui</h6>
                            <h3 class="mb-0">{{ $approvedChanges }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Ditolak</h6>
                            <h3 class="mb-0">{{ $rejectedChanges }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-x-circle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Changes Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Perubahan Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover" id="changesTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Aplikasi</th>
                            <th>Perubahan</th>
                            <th>Status</th>
                            <th>Persetujuan</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#changesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: "{{ route('dashboard.changes.data') }}",
                type: 'GET'
            },
            columnDefs: [
                {
                    targets: [0], // No column
                    responsivePriority: 1,
                    width: "5%"
                },
                {
                    targets: [1], // Aplikasi
                    responsivePriority: 2,
                    width: "15%"
                },
                {
                    targets: [6], // Aksi
                    responsivePriority: 1,
                    width: "10%"
                },
                {
                    targets: [2], // Perubahan
                    responsivePriority: 5,
                    width: "25%"
                },
                {
                    targets: [3, 4], // Status, Persetujuan
                    responsivePriority: 8,
                    width: "12%"
                },
                {
                    targets: [5], // Tanggal Update
                    responsivePriority: 10,
                    width: "12%"
                }
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    className: 'text-center'
                },
                {
                    data: 'application_name',
                    name: 'application.nama',
                    title: 'Aplikasi',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 15) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 120px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'perubahan',
                    name: 'perubahan',
                    title: 'Perubahan',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 30) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 150px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'tingkat_kepentingan_badge',
                    name: 'tingkat_kepentingan',
                    title: 'Status',
                    orderable: true,
                    searchable: true,
                    className: 'text-center'
                },
                {
                    data: 'approval_status_badge',
                    name: 'approval_status',
                    title: 'Persetujuan',
                    orderable: true,
                    searchable: true,
                    width: '10%',
                    className: 'text-center'
                },
                {
                    data: 'formatted_date',
                    name: 'updated_at',
                    title: 'Tanggal Update',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    className: 'text-center'
                }
            ],
            order: [[5, 'desc']], // Order by date column descending
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                processing: "Memuat data...",
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Tidak ada data yang tersedia",
                zeroRecords: "Tidak ada data yang cocok dengan pencarian"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function(settings) {
                // Re-initialize tooltips if any
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    });
</script>
@endpush