@extends('layouts.app')

@section('title', 'Edit Perubahan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 style="color: #00A67C" class="mb-4">Edit Perubahan</h4>

                    <form action="{{ route('changes.update', $change->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="perubahan" class="form-label">Perubahan:</label>
                            <textarea class="form-control" name="perubahan" rows="4"
                                required>{{ $change->perubahan }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tingkat_kepentingan" class="form-label">Tingkat Kepentingan:</label>
                            <select class="form-select" name="tingkat_kepentingan" required>
                                <option value="Normal" {{ $change->tingkat_kepentingan == 'Normal' ? 'selected' : '' }}>
                                    Normal</option>
                                <option value="Mendesak"
                                    {{ $change->tingkat_kepentingan == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="request_date" class="form-label">Tanggal Permintaan:</label>
                            <input type="date" class="form-control" name="request_date"
                                value="{{ $change->request_date }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="version" class="form-label">Versi:</label>
                            <input type="text" class="form-control" name="version" value="{{ $change->version }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="approval_date" class="form-label">Tanggal Persetujuan:</label>
                            <input type="date" class="form-control" name="approval_date"
                                value="{{ $change->approval_date }}">
                        </div>

                        <div class="mb-3">
                            <label for="uat_date" class="form-label">Tanggal UAT:</label>
                            <input type="date" class="form-control" name="uat_date" value="{{ $change->uat_date }}">
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Tanggal Rilis:</label>
                            <input type="date" class="form-control" name="release_date"
                                value="{{ $change->release_date }}">
                        </div>

                        <div class="mb-3">
                            <label for="target_release_date" class="form-label">Tanggal Rilis Target:</label>
                            <input type="date" class="form-control" name="target_release_date"
                                value="{{ $change->target_release_date }}">
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-tambah me-2">
                                <i class="bi bi-save me-1"></i>Update
                            </button>
                            <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection