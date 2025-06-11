@extends('layouts.app')

@section('title', 'Aplikasi')

@section('header-title', 'Aplikasi')

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

    #applicationsTable {
        width: 100% !important;
        border-collapse: collapse;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    #applicationsTable thead th {
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

    #applicationsTable tbody td {
        border: none;
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }
    
    #applicationsTable tbody tr {
        transition: all 0.2s ease;
    }
    
    #applicationsTable tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

    /* Mobile responsive adjustments for applications table */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between.align-items-center h2 {
            font-size: 1.5rem;
        }
        
        #applicationsTable thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.7rem;
        }
        
        #applicationsTable tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .btn-action {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
            margin: 0.1rem;
        }
        
        .card-body {
            padding: 1rem;
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
        .d-flex.justify-content-between.align-items-center h2 {
            font-size: 1.2rem;
        }
        
        #applicationsTable {
            font-size: 0.7rem;
        }
        
        #applicationsTable th,
        #applicationsTable td {
            padding: 0.3rem 0.15rem;
        }
        
        .btn-sm {
            padding: 0.15rem 0.3rem;
            font-size: 0.65rem;
        }
        
        .btn-sm i {
            font-size: 0.7rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
    }
    
    /* DataTables responsive styling */
    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        margin: 0 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Daftar Aplikasi</h2>
        @can('create-applications')
        <a href="{{ route('applications.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Aplikasi
        </a>
        @endcan
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="applicationsTable">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="15%">Nama</th>
                            <th width="20%">Fungsi</th>
                            <th width="15%">Pengguna</th>
                            <th width="15%">Pemilik</th>
                            <th width="15%">Pengembang</th>
                            <th width="15%">Aksi</th>
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
        var table = $('#applicationsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: "{{ route('applications.data') }}",
                type: 'GET'
            },
            columnDefs: [
                {
                    targets: [0], // No column
                    responsivePriority: 1,
                    width: "5%"
                },
                {
                    targets: [1], // Nama
                    responsivePriority: 2,
                    width: "15%"
                },
                {
                    targets: [6], // Action
                    responsivePriority: 1,
                    width: "15%"
                },
                {
                    targets: [2, 3, 4, 5], // Fungsi, Pengguna, Pemilik, Pengembang
                    responsivePriority: 10,
                    width: "17%"
                }
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 20) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 150px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'fungsi',
                    name: 'fungsi',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 30) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 150px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'pengguna',
                    name: 'pengguna',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 20) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 120px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'pemilik',
                    name: 'pemilik',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 20) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 120px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'pengembang',
                    name: 'pengembang',
                    className: 'text-start',
                    render: function(data, type, row) {
                        if (type === 'display' && data && data.length > 20) {
                            return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 120px;">' + data + '</span>';
                        }
                        return data || 'N/A';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ],
            order: [[1, 'asc']], // Order by nama column ascending
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
                emptyTable: "Tidak ada data aplikasi",
                zeroRecords: "Tidak ada data yang cocok dengan pencarian"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function(settings) {
                // Re-initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    });

    // Enhanced delete function with AJAX and SweetAlert2
    function deleteApplication(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus aplikasi ini?',
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

                $.ajax({
                    url: '{{ route("applications.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                            $('#applicationsTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus aplikasi';
                        Swal.fire({
                            title: 'Gagal!',
                            text: errorMessage,
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