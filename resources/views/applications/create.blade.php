@extends('layouts.app')

@section('title', 'Identitas Aplikasi')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 style="color: #00A67C" class="mb-4">Identitas Aplikasi</h4>

                    <form action="{{ route('applications.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Aplikasi</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}"
                                        placeholder="Masukkan nama aplikasi">
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fungsi" class="form-label">Fungsi</label>
                                    <textarea class="form-control @error('fungsi') is-invalid @enderror" id="fungsi"
                                        name="fungsi" rows="3"
                                        placeholder="Masukkan fungsi aplikasi">{{ old('fungsi') }}</textarea>
                                    @error('fungsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pengguna" class="form-label">Pengguna</label>
                                    <input type="text" class="form-control @error('pengguna') is-invalid @enderror"
                                        id="pengguna" name="pengguna" value="{{ old('pengguna') }}"
                                        placeholder="Masukkan pengguna aplikasi">
                                    @error('pengguna')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pemilik" class="form-label">Pemilik</label>
                                    <input type="text" class="form-control @error('pemilik') is-invalid @enderror"
                                        id="pemilik" name="pemilik" value="{{ old('pemilik') }}"
                                        placeholder="Masukkan pemilik aplikasi">
                                    @error('pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pengembang" class="form-label">Pengembang</label>
                                    <input type="text" class="form-control @error('pengembang') is-invalid @enderror"
                                        id="pengembang" name="pengembang" value="{{ old('pengembang') }}"
                                        placeholder="Masukkan pengembang aplikasi">
                                    @error('pengembang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end flex-column flex-sm-row">
                            <button type="submit" class="btn btn-tambah me-0 me-sm-2 mb-2 mb-sm-0">
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

<style>
/* Mobile Responsive Styles for Forms */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .card-body h4 {
        font-size: 1.3rem;
        margin-bottom: 1.5rem !important;
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
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-end {
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
        padding: 1rem !important;
    }
    
    .card-body h4 {
        font-size: 1.2rem;
        text-align: center;
    }
    
    .form-control {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn-tambah, .btn-secondary {
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }
}
</style>
@endsection