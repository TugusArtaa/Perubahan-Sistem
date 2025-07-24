@extends('layouts.app')

@section('title', 'Aplikasi')

@section('header-title', 'Aplikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Daftar Aplikasi</h2>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-3">
        @can('create-applications')
        <a href="{{ route('applications.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Aplikasi
        </a>
        @endcan
        @can('delete-applications')
        <button id="bulkDeleteBtn" class="btn btn-danger d-none">
            <i class="bi bi-trash me-1"></i>
            Hapus Terpilih
        </button>
        @endcan
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="applicationsTable">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="3%">
                                <input type="checkbox" id="selectAll">
                            </th>
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
            ajax: {
                url: "{{ route('applications.data') }}",
                type: 'GET'
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '3%'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    className: 'text-center'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    title: 'Nama'
                },
                {
                    data: 'fungsi',
                    name: 'fungsi',
                    title: 'Fungsi'
                },
                {
                    data: 'pengguna',
                    name: 'pengguna',
                    title: 'Pengguna'
                },
                {
                    data: 'pemilik',
                    name: 'pemilik',
                    title: 'Pemilik'
                },
                {
                    data: 'pengembang',
                    name: 'pengembang',
                    title: 'Pengembang'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                }
            ],
            order: [[1, 'asc']], // Order by nama column ascending
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
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
                // Bulk delete: reset select all and button
                $('#selectAll').prop('checked', false);
                toggleBulkDeleteBtn();
            }
        });

        // Handle select all
        $('#selectAll').on('click', function() {
            var checked = $(this).is(':checked');
            $('.row-checkbox').prop('checked', checked);
            toggleBulkDeleteBtn();
        });

        // Handle row checkbox click
        $(document).on('change', '.row-checkbox', function() {
            var allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
            $('#selectAll').prop('checked', allChecked);
            toggleBulkDeleteBtn();
        });

        // Toggle bulk delete button
        function toggleBulkDeleteBtn() {
            var selected = $('.row-checkbox:checked').length;
            if (selected > 0) {
                $('#bulkDeleteBtn').removeClass('d-none');
            } else {
                $('#bulkDeleteBtn').addClass('d-none');
            }
        }

        // Bulk delete button click
        $('#bulkDeleteBtn').on('click', function() {
            var ids = $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) return;

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus ' + ids.length + ' aplikasi terpilih?',
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
                        url: '{{ route("applications.bulkDelete") }}',
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