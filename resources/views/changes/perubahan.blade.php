@extends('layouts.app')

@section('title', 'Daftar Perubahan')

@section('header-title', 'Perubahan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Daftar Perubahan</h2>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <!-- DataTables responsive wrapper -->
                <div class="table-responsive">
                    <table id="changesTable" class="table table-hover table-striped mb-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" data-priority="1">No</th>
                                <th data-priority="2">Aplikasi</th>
                                <th data-priority="3">Perubahan</th>
                                <th class="text-center" data-priority="4">Kepentingan</th>
                                <th class="text-center" data-priority="5">Status</th>
                                <th class="text-center" data-priority="6">Approval</th>
                                <th class="text-center" data-priority="7">Tgl Permintaan</th>
                                <th class="text-center" data-priority="8">Versi</th>
                                <th class="text-center" data-priority="9">Tgl Persetujuan</th>
                                <th class="text-center" data-priority="10">Tgl Target</th>
                                <th class="text-center" data-priority="1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Enhanced Table Container Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-body {
            padding: 0;
        }
        
        /* Enhanced Table Styling */
        .table-responsive {
            border: none;
            margin: 0;
            border-radius: 15px;
            overflow: hidden;
        }

        #changesTable {
            width: 100% !important;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        #changesTable thead th {
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

        #changesTable tbody td {
            border: none;
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }
        
        #changesTable tbody tr {
            transition: all 0.2s ease;
        }
        
        #changesTable tbody tr:hover {
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

        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.6;
        }

        .dataTables_processing {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #999;
            font-size: 14px;
            text-align: center;
            padding: 1em;
        }

        /* Responsive text handling */
        #changesTable td.text-truncate {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            #changesTable thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.7rem;
            }
            
            #changesTable tbody td {
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
        
        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem;
            }
            
            #changesTable {
                font-size: 0.75rem;
            }
            
            #changesTable th,
            #changesTable td {
                padding: 0.5rem 0.25rem;
            }
        }
    </style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables with responsive features
        const table = $('#changesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: '{{ route('changes.data') }}',
                type: 'GET'
            },
            language: {
                processing: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>',
                lengthMenu: "Show _MENU_ entries",
                search: "Search:",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                emptyTable: "No data available"
            },
            columnDefs: [{
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
                    targets: [2], // Perubahan
                    responsivePriority: 3,
                    width: "25%"
                },
                {
                    targets: [3], // Kepentingan
                    responsivePriority: 4,
                    width: "10%"
                },
                {
                    targets: [4], // Status
                    responsivePriority: 5,
                    width: "10%"
                },
                {
                    targets: [5], // Approval
                    responsivePriority: 6,
                    width: "15%"
                },
                {
                    targets: [10], // Aksi
                    responsivePriority: 1,
                    width: "10%"
                },
                {
                    targets: [6, 7, 8, 9], // Date columns
                    responsivePriority: 10,
                    width: "8%"
                }
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'application_name',
                    name: 'application.nama',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 15) {
                            return '<span title="' + data +
                                '" class="text-truncate d-inline-block" style="max-width: 120px;">' +
                                data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'perubahan',
                    name: 'perubahan',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 40) {
                            return '<span title="' + data +
                                '" class="text-truncate d-inline-block" style="max-width: 200px;">' +
                                data + '</span>';
                        }
                        return data || '-';
                    }
                },
                {
                    data: 'tingkat_kepentingan_badge',
                    name: 'tingkat_kepentingan',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'approval_status_badge',
                    name: 'approval_status',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'approval',
                    name: 'approval',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'formatted_request_date',
                    name: 'request_date',
                    className: 'text-center'
                },
                {
                    data: 'version',
                    name: 'version',
                    className: 'text-center'
                },
                {
                    data: 'formatted_approval_date',
                    name: 'approval_date',
                    className: 'text-center'
                },
                {
                    data: 'formatted_target_date',
                    name: 'target_release_date',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '140px'
                },
            ],
            order: [
                [6, 'desc']
            ], // Order by request_date descending
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua"]
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            {
                data: 'tingkat_kepentingan_badge',
                name: 'tingkat_kepentingan',
                className: 'text-center',
                orderable: false,
                width: '100px'
            },
            {
                data: 'approval_status_badge',
                name: 'approval_status',
                className: 'text-center',
                orderable: false,
                width: '90px'
            },
            {
                data: 'approval',
                name: 'approval',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '140px'
            },
            {
                data: 'formatted_request_date',
                name: 'request_date',
                className: 'text-center',
                width: '110px'
            },
            {
                data: 'version',
                name: 'version',
                className: 'text-center',
                width: '80px'
            },
            {
                data: 'formatted_approval_date',
                name: 'approval_date',
                className: 'text-center',
                width: '110px'
            },
            {
                data: 'formatted_target_date',
                name: 'target_release_date',
                className: 'text-center',
                width: '110px'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '140px'
            },
        ],
        order: [[6, 'desc']], // Order by request_date descending
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        scrollX: true,
        scrollCollapse: true,
        responsive: false, // Disable responsive, use scrollX instead
        autoWidth: false,
        columnDefs: [
            {
                targets: [10], // Action column
                responsivePriority: 1,
                width: "120px",
                orderable: false,
                searchable: false,
                className: 'text-center align-middle'
            },
            // ... other column definitions
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function() {
            // Initialize tooltips after each draw
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Delete function for changes
    function deleteChange(changeId, applicationId) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang memproses permintaan Anda',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get the CSRF token
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/applications/${applicationId}/changes/${changeId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload DataTable
                            $('#changesTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Gagal menghapus perubahan.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menghapus perubahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Gagal!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    // Function to approve a change
    function approveChange(changeId) {
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            text: 'Apakah Anda yakin ingin menyetujui perubahan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memproses persetujuan',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get the CSRF token
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/changes/${changeId}/approve`,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload DataTable
                            $('#changesTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Gagal menyetujui perubahan.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menyetujui perubahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Gagal!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    // Function to reject a change
    function rejectChange(changeId) {
        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak perubahan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memproses penolakan',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get the CSRF token
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/changes/${changeId}/reject`,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Reload DataTable
                            $('#changesTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Gagal menolak perubahan.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menolak perubahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Gagal!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
