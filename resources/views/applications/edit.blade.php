@extends('layouts.app')

@section('title', 'Edit Aplikasi')

@section('header-title', 'Aplikasi')

@push('styles')
<style>
    /* Mobile responsive adjustments for applications edit form */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        h4 {
            font-size: 1.25rem;
        }
        
        .row {
            margin: 0;
        }
        
        .col-md-6 {
            padding-left: 0;
            padding-right: 0;
        }
        
        .form-control,
        .form-select {
            font-size: 16px; /* Prevent zoom on iOS */
            padding: 0.5rem 0.75rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-2 .btn {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .card-body {
            padding: 0.75rem !important;
        }
        
        h4 {
            font-size: 1.1rem;
        }
        
        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .form-control,
        .form-select {
            font-size: 16px;
            padding: 0.4rem 0.6rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
    
    /* Enhanced button styling for mobile */
    .d-flex.gap-2 {
        display: flex;
        gap: 1rem;
    }
    
    @media (min-width: 576px) {
        .d-flex.gap-2 {
            flex-direction: row;
        }
        
        .d-flex.gap-2 .btn {
            width: auto;
            flex: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 style="color: #00A67C" class="mb-4">Edit Aplikasi</h4>

                    <form action="{{ route('applications.update', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Aplikasi</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama', $application->nama) }}"
                                        placeholder="Masukkan nama aplikasi">
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fungsi" class="form-label">Fungsi</label>
                                    <textarea class="form-control @error('fungsi') is-invalid @enderror" id="fungsi"
                                        name="fungsi" rows="3"
                                        placeholder="Masukkan fungsi aplikasi">{{ old('fungsi', $application->fungsi) }}</textarea>
                                    @error('fungsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pengguna" class="form-label">Pengguna</label>
                                    <input type="text" class="form-control @error('pengguna') is-invalid @enderror"
                                        id="pengguna" name="pengguna"
                                        value="{{ old('pengguna', $application->pengguna) }}"
                                        placeholder="Masukkan pengguna aplikasi">
                                    @error('pengguna')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pemilik" class="form-label">Pemilik</label>
                                    <input type="text" class="form-control @error('pemilik') is-invalid @enderror"
                                        id="pemilik" name="pemilik" value="{{ old('pemilik', $application->pemilik) }}"
                                        placeholder="Masukkan pemilik aplikasi">
                                    @error('pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pengembang" class="form-label">Pengembang</label>
                                    <input type="text" class="form-control @error('pengembang') is-invalid @enderror"
                                        id="pengembang" name="pengembang"
                                        value="{{ old('pengembang', $application->pengembang) }}"
                                        placeholder="Masukkan pengembang aplikasi">
                                    @error('pengembang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2 flex-column flex-sm-row">
                            <button type="submit" class="btn btn-tambah">
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