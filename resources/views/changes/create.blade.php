@extends('layouts.app')

@section('title', 'Tambah Perubahan untuk ' . $application->nama)

@section('header-title', 'Perubahan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 style="color: #00A67C" class="mb-4">Tambah Perubahan untuk {{ $application->nama }}</h4>

                    <form action="{{ route('application.changes.store', $application->id) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="perubahan" class="form-label">Perubahan:</label>
                                <textarea class="form-control" name="perubahan" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="tingkat_kepentingan" class="form-label">Tingkat Kepentingan:</label>
                                <select class="form-select" name="tingkat_kepentingan" required>
                                    <option value="Normal">Normal</option>
                                    <option value="Mendesak">Mendesak</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="approval_status" class="form-label">Status Persetujuan:</label>
                                <select class="form-select" name="approval_status">
                                    <option value="pending" selected>Menunggu Persetujuan</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="request_date" class="form-label">Tanggal Permintaan:</label>
                                <input type="date" class="form-control" name="request_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="version" class="form-label">Versi:</label>
                                <input type="text" class="form-control" name="version" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="approval_date" class="form-label">Tanggal Persetujuan:</label>
                                <input type="date" class="form-control" name="approval_date">
                            </div>
                            <div class="col-md-6">
                                <label for="uat_date" class="form-label">Tanggal UAT:</label>
                                <input type="date" class="form-control" name="uat_date">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="release_date" class="form-label">Tanggal Rilis:</label>
                                <input type="date" class="form-control" name="release_date">
                            </div>
                            <div class="col-md-6">
                                <label for="target_release_date" class="form-label">Tanggal Rilis Target:</label>
                                <input type="date" class="form-control" name="target_release_date">
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-tambah me-2" id="submitBtn">
                                <i class="bi bi-save me-1"></i>Simpan
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

@push('scripts')
<script>
$(document).ready(function() {
    // Form submission with SweetAlert2 confirmation
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan data perubahan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Sedang memproses data perubahan',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                this.submit();
            }
        });
    });
    
    // Show validation errors with SweetAlert2
    @if($errors->any())
        let errorMessages = '';
        @foreach($errors->all() as $error)
            errorMessages += '• {{ $error }}\n';
        @endforeach
        
        Swal.fire({
            title: 'Validasi Gagal!',
            text: errorMessages,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
@endpush