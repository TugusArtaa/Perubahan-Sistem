@extends('layouts.app')

@section('title', 'Daftar Perubahan')

@section('header-title', 'Perubahan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Daftar Perubahan</h2>
    </div>

    <div class="d-flex justify-content-start" style="margin-left:85%; margin-bottom: 0.5rem;">
        {{-- @can('create-changes')
        <a href="{{ route('changes.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Perubahan
        </a>
        @endcan --}}
        @can('delete-changes')
        <button id="bulkDeleteChangesBtn" class="btn btn-danger d-none">
            <i class="bi bi-trash me-1"></i>
            Hapus Terpilih
        </button>
        @endcan
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <!-- DataTables wrapper for horizontal scroll -->
            <div style="overflow-x: auto; padding: 1rem;">
                <table id="changesTable" class="table table-hover table-striped mb-0 w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="min-width: 40px;">
                                <input type="checkbox" id="selectAllChanges">
                            </th>
                            <th class="text-center" style="min-width: 50px;">No</th>
                            <th style="min-width: 120px;">Aplikasi</th>
                            <th style="min-width: 200px;">Perubahan</th>
                            <th class="text-center" style="min-width: 100px;">Kepentingan</th>
                            <th class="text-center" style="min-width: 90px;">Persetujuan</th>
                            <th class="text-center" style="min-width: 140px;">Approval</th>
                            <th class="text-center" style="min-width: 110px;">Tgl Permintaan</th>
                            <th class="text-center" style="min-width: 80px;">Versi</th>
                            <th class="text-center" style="min-width: 110px;">Tgl Persetujuan</th>
                            <th class="text-center" style="min-width: 110px;">Tgl Target Rilis</th>
                            <th class="text-center" style="min-width: 140px;">Aksi</th>
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
    
    /* DataTables responsive and overflow handling */
    .dataTables_wrapper {
        overflow-x: visible;
    }
    
    .dataTables_scroll {
        overflow-x: auto;
    }
    
    .dataTables_scrollBody {
        overflow-x: auto;
    }
    
    #changesTable {
        width: 100% !important;
        min-width: 1000px;
        border-collapse: collapse;
    }
    
    #changesTable th,
    #changesTable td {
        padding: 8px 12px;
        vertical-align: middle;
    }
    
    /* Special handling for longer content columns */
    #changesTable td:nth-child(3) { /* Perubahan column */
        max-width: 250px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.4;
    }
    
    #changesTable td:nth-child(2) { /* Aplikasi column */
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Other columns with ellipsis for very long content */
    #changesTable td:not(:nth-child(3)):not(:nth-child(2)) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Ensure action buttons don't wrap */
    #changesTable td:last-child {
        white-space: nowrap;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        #changesTable {
            min-width: 800px;
            font-size: 0.875rem;
        }
        
        #changesTable th,
        #changesTable td {
            padding: 6px 8px;
        }
        
        .table-responsive {
            border: none;
        }
        
        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        .dataTables_length label,
        .dataTables_filter label {
            font-size: 0.875rem;
        }
    }
    
    /* DataTables control styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem;
    }
    
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

    /* Custom: force DataTables search box to left */
    .dataTables-search-left {
        justify-content: flex-start !important;
        display: flex !important;
        padding-left: 0 !important;
    }

    /* Custom: Remove the search label, round and lengthen the search input */
    .dataTables-search-left label {
        width: 100%;
        margin-bottom: 0;
    }
    .dataTables-search-left label > input[type="search"] {
        border-radius: 2rem !important;
        border: 1px solid #ced4da;
        padding: 0.5rem 1.5rem;
        width: 400px !important;
        max-width: 100%;
        margin-left: 0 !important;
        font-size: 1rem;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: border-color 0.2s;
    }
    .dataTables-search-left label > span {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables
    const table = $('#changesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("changes.data") }}',
            type: 'GET'
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '40px'
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '50px'
            },
            {
                data: 'application_name',
                name: 'application.nama',
                className: 'text-start',
                render: function(data, type, row) {
                    if (type === 'display' && data && data.length > 20) {
                        return '<span title="' + data + '">' + data.substr(0, 20) + '...</span>';
                    }
                    return data || 'N/A';
                }
            },
            {
                data: 'perubahan',
                name: 'perubahan',
                className: 'text-start',
                render: function(data, type, row) {
                    if (type === 'display' && data && data.length > 50) {
                        return '<span title="' + data + '">' + data.substr(0, 50) + '...</span>';
                    }
                    return data || '-';
                }
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
        // language: {
        //     url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        // },
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
        language: {
                processing: "Memuat data...",
                search: "",
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
            dom: '<"row align-items-center"<"col-12 col-md-6 d-flex justify-content-start"f><"col-12 col-md-6 text-end"l>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function(settings) {
                // Re-initialize tooltips if any
                $('[data-bs-toggle="tooltip"]').tooltip();
                // Set placeholder for search input
                $(this.api().table().container()).find('input[type="search"]').attr('placeholder', 'Pencarian');
                $('#selectAllChanges').prop('checked', false);
                toggleBulkDeleteChangesBtn();
            }
    });

    // Handle select all
    $('#selectAllChanges').on('click', function() {
        var checked = $(this).is(':checked');
        $('.row-checkbox-changes').prop('checked', checked);
        toggleBulkDeleteChangesBtn();
    });

    // Handle row checkbox click
    $(document).on('change', '.row-checkbox-changes', function() {
        var allChecked = $('.row-checkbox-changes').length === $('.row-checkbox-changes:checked').length;
        $('#selectAllChanges').prop('checked', allChecked);
        toggleBulkDeleteChangesBtn();
    });

    // Toggle bulk delete button
    function toggleBulkDeleteChangesBtn() {
        var selected = $('.row-checkbox-changes:checked').length;
        if (selected > 0) {
            $('#bulkDeleteChangesBtn').removeClass('d-none');
        } else {
            $('#bulkDeleteChangesBtn').addClass('d-none');
        }
    }

    // Bulk delete button click
    $('#bulkDeleteChangesBtn').on('click', function() {
        var ids = $('.row-checkbox-changes:checked').map(function() {
            return $(this).val();
        }).get();

        if (ids.length === 0) return;

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus ' + ids.length + ' perubahan terpilih?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
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
                    url: '{{ route("changes.bulkDelete") }}',
                    type: 'POST',
                    data: { ids: ids },
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
                            $('#changesTable').DataTable().ajax.reload();
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
                        const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus perubahan';
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
    });

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