@extends('layouts.app')

@section('title', 'Edit Aplikasi')

@section('heade                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-tambah me-2" id="submitBtn">
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

@push('scripts')
<script>
$(document).ready(function() {
    // Form submission with SweetAlert2 confirmation
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah Anda yakin ingin memperbarui data aplikasi ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memperbarui...',
                    text: 'Sedang memproses pembaruan data aplikasi',
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
@endpushkasi')

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