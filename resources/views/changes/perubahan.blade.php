@extends('layouts.app')

@section('title', 'Daftar Perubahan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #00A67C">Daftar Perubahan</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr class="table-header text-center">
                    <th width="5%">No</th>
                    <th width="20%">Perubahan</th>
                    <th width="15%">Tingkat Kepentingan</th>
                    <th width="15%">Tanggal Permintaan</th>
                    <th width="10%">Versi</th>
                    <th width="15%">Tanggal Persetujuan</th>
                    <th width="15%">Tanggal Rilis</th>
                    <th width="15%">Tanggal Rilis Target</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($changes as $index => $change)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $change->perubahan }}</td>
                    <td>{{ $change->tingkat_kepentingan }}</td>
                    <td>{{ $change->request_date }}</td>
                    <td>{{ $change->version }}</td>
                    <td>{{ $change->approval_date }}</td>
                    <td>{{ $change->release_date }}</td>
                    <td>{{ $change->target_release_date }}</td>
                    <td class="text-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('changes.edit', $change->id) }}" class="btn btn-sm btn-warning me-2"
                                data-tippy-content="Edit Perubahan">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form
                                action="{{ route('changes.destroy', ['application' => $change->application_id, 'change' => $change->id]) }}"
                                method="POST" class="d-inline" data-tippy-content="Hapus Perubahan">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus perubahan ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data perubahan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection