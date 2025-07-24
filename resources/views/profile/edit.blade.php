@extends('layouts.app')

@section('title', 'Edit Profil')

@section('header-title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-gear me-2"></i>
                        Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Perbarui informasi profil dan alamat email akun Anda.</p>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-warning small">
                                        Alamat email Anda belum diverifikasi.
                                        <button form="send-verification" class="btn btn-link p-0 text-decoration-underline small">
                                            Klik di sini untuk mengirim ulang email verifikasi.
                                        </button>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>

                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Profil berhasil diperbarui!
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Perbarui Kata Sandi
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-shield-check me-1"></i>
                            Perbarui Kata Sandi
                        </button>

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Kata sandi berhasil diperbarui!
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card border-0 shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Hapus Akun
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                        Sebelum menghapus akun Anda, silakan unduh data atau informasi yang ingin Anda simpan.
                    </p>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        <i class="bi bi-trash me-1"></i>
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Konfirmasi Penghapusan Akun
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    
                    <div class="mb-3">
                        <label for="password_delete" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                               id="password_delete" name="password" placeholder="Masukkan kata sandi Anda untuk konfirmasi" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Verification Form (hidden) -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>
@endif

@endsection

<style>
.card-header.bg-success {
    background: linear-gradient(135deg, #198754, #157347) !important;
}

.card-header.bg-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800) !important;
}

.card-header.bg-danger {
    background: linear-gradient(135deg, #dc3545, #c82333) !important;
}

.form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.btn-success:hover {
    background-color: #157347;
    border-color: #146c43;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.alert {
    border: none;
    border-radius: 8px;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Confirm password validation
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    if (passwordField && confirmPasswordField) {
        confirmPasswordField.addEventListener('input', function() {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity('Kata sandi tidak cocok');
            } else {
                confirmPasswordField.setCustomValidity('');
            }
        });
    }

    // Add loading state to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
                
                // Re-enable after 3 seconds if form doesn't submit
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 3000);
            }
        });
    });
});
</script>
