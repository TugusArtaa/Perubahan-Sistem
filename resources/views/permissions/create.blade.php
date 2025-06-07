@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle"></i> Create New Permission
                    </h5>
                </div>
                <div class="card-body">
                    <form id="permissionForm" method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="e.g., create-users, view-reports" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Use lowercase with hyphens (e.g., create-users, edit-posts, view-dashboard)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h6><i class="bi bi-lightbulb"></i> Common Permission Examples:</h6>
                                    <ul class="mb-0">
                                        <li><strong>Users:</strong> view-users, create-users, edit-users, delete-users</li>
                                        <li><strong>Applications:</strong> view-applications, create-applications, edit-applications, delete-applications</li>
                                        <li><strong>Changes:</strong> view-changes, create-changes, edit-changes, delete-changes, approve-changes</li>
                                        <li><strong>Reports:</strong> view-reports, export-reports</li>
                                        <li><strong>System:</strong> manage-roles, manage-permissions, view-dashboard</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Permissions
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Create Permission
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#permissionForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to create this permission?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData(this);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = "{{ route('permissions.index') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                text: errorMessage
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while creating the permission.'
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>
@endpush
