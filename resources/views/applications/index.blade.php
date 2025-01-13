@extends('layouts.app')

@section('title', 'Aplikasi')

@section('header-title', 'Aplikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success">Daftar Aplikasi</h2>
        <a href="{{ route('applications.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Aplikasi
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="15%">Nama</th>
                            <th width="20%">Fungsi</th>
                            <th width="15%">Pengguna</th>
                            <th width="15%">Pemilik</th>
                            <th width="15%">Pengembang</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $index => $application)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $application->nama }}</td>
                            <td>{{ $application->fungsi }}</td>
                            <td>{{ $application->pengguna }}</td>
                            <td>{{ $application->pemilik }}</td>
                            <td>{{ $application->pengembang }}</td>
                            <td class="text-center">
                                <a href="{{ route('applications.edit', $application->id) }}"
                                    class="btn btn-sm btn-warning" data-tippy-content="Edit Aplikasi">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('changes.create', $application->id) }}" class="btn btn-sm btn-info"
                                    data-tippy-content="Tambah Perubahan">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                                <form action="{{ route('applications.destroy', $application->id) }}" method="POST"
                                    class="d-inline" data-tippy-content="Hapus Aplikasi">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus aplikasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data aplikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection