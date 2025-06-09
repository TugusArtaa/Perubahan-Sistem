@extends('layouts.app')

@section('title', 'User Management')

@push('styles')
<style>
    /* Mobile responsive adjustments for users table */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .card-header .btn {
            width: 100%;
        }
        
        .table-responsive {
            margin: 0.5rem;
        }
        
        #usersTable {
            font-size: 0.8rem;
        }
        
        #usersTable th,
        #usersTable td {
            padding: 0.5rem 0.25rem;
        }
        
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
        
        .card-body {
            padding: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        #usersTable {
            font-size: 0.7rem;
        }
        
        #usersTable th,
        #usersTable td {
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people"></i> User Management
                        </h5>
                        @can('create-users')
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add New User
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.data') }}",
                responsive: true,
                scrollX: true,
                columnDefs: [
                    {
                        targets: [0], // ID column
                        responsivePriority: 1,
                        width: "8%"
                    },
                    {
                        targets: [1], // Name column
                        responsivePriority: 2,
                        width: "20%"
                    },
                    {
                        targets: [5], // Actions column
                        responsivePriority: 1,
                        width: "20%"
                    },
                    {
                        targets: [2], // Email column
                        responsivePriority: 3,
                        width: "25%"
                    },
                    {
                        targets: [3], // Roles column
                        responsivePriority: 6,
                        width: "15%"
                    },
                    {
                        targets: [4], // Created At column
                        responsivePriority: 10,
                        width: "12%"
                    }
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-start fw-bold',
                        render: function(data, type, row) {
                            if (type === 'display' && data && data.length > 20) {
                                return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 150px;">' + data + '</span>';
                            }
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-start',
                        render: function(data, type, row) {
                            if (type === 'display' && data && data.length > 25) {
                                return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 180px;">' + data + '</span>';
                            }
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false,
                        className: 'text-start',
                        render: function(data, type, row) {
                            if (type === 'display' && data && data.length > 20) {
                                return '<span title="' + data + '" class="text-truncate d-inline-block" style="max-width: 100px;">' + data + '</span>';
                            }
                            return data || 'No roles';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    processing: '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>',
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    emptyTable: "No users available",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                drawCallback: function() {
                    // Initialize tooltips after each draw
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });

            // Delete user functionality
            $(document).on('click', '.delete-user', function() {
                var userId = $(this).data('id');
                var row = $(this).closest('tr');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ route('users.destroy', ':id') }}".replace(':id',
                                userId),
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    );
                                    table.ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the user.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Handle session success message
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>
@endpush
