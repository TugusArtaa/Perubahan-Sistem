@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil"></i> Edit Role: {{ $role->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="roleForm" method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Permissions</label>
                                    <div class="row permission-grid">
                                        @foreach($permissions as $permission)
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="permissions[]" value="{{ $permission->name }}" 
                                                           id="permission_{{ $permission->id }}"
                                                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($permissions->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle"></i> No permissions available. 
                                            <a href="{{ route('permissions.create') }}">Create permissions first</a>.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between flex-column flex-sm-row">
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary mb-2 mb-sm-0">
                                        <i class="bi bi-arrow-left"></i> Back to Roles
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-check-circle"></i> Update Role
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

<style>
/* Mobile Responsive Styles for Role Forms */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .card-header h5 {
        font-size: 1.2rem;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        font-size: 0.9rem;
        padding: 0.6rem 0.75rem;
    }
    
    .permission-grid .col-lg-3,
    .permission-grid .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .form-check {
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        background-color: #f8f9fa;
    }
    
    .form-check-label {
        font-size: 0.9rem;
        padding-left: 0.5rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-between {
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 0.5rem;
    }
    
    .card {
        margin: 0;
        border-radius: 0.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-header h5 {
        font-size: 1.1rem;
        text-align: center;
    }
    
    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
    
    .alert {
        font-size: 0.9rem;
        padding: 0.75rem;
    }
}
</style>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#roleForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update this role?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, update it!'
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
                                window.location.href = "{{ route('roles.index') }}";
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
                                text: 'An error occurred while updating the role.'
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
