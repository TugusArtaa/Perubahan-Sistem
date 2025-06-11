@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle"></i> User Details: {{ $user->name }}
                    </h5>
                    <div>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bi bi-person-badge"></i> Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Full Name:</strong></td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email Verified:</strong></td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Verified
                                                    </span>
                                                    <small class="text-muted d-block">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-exclamation-triangle"></i> Not Verified
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Member Since:</strong></td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bi bi-shield-check"></i> Roles & Permissions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Assigned Roles:</strong>
                                        <div class="mt-2">
                                            @if($user->roles->count() > 0)
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-primary me-1 mb-1">
                                                        <i class="bi bi-award"></i> {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No roles assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>All Permissions:</strong>
                                        <div class="mt-2" style="max-height: 200px; overflow-y: auto;">
                                            @if($user->getAllPermissions()->count() > 0)
                                                @foreach($user->getAllPermissions() as $permission)
                                                    <span class="badge bg-secondary me-1 mb-1" style="font-size: 0.7rem;">
                                                        <i class="bi bi-key"></i> {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No permissions assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="bi bi-activity"></i> User Activity Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-primary mb-0">
                                                    {{ $user->roles->count() }}
                                                </h4>
                                                <small class="text-muted">Roles Assigned</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-success mb-0">
                                                    {{ $user->getAllPermissions()->count() }}
                                                </h4>
                                                <small class="text-muted">Total Permissions</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-end">
                                                <h4 class="text-info mb-0">
                                                    {{ $user->created_at->diffInDays() }}
                                                </h4>
                                                <small class="text-muted">Days as Member</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h4 class="text-warning mb-0">
                                                @if($user->email_verified_at)
                                                    <i class="bi bi-shield-check"></i>
                                                @else
                                                    <i class="bi bi-shield-exclamation"></i>
                                                @endif
                                            </h4>
                                            <small class="text-muted">Account Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
