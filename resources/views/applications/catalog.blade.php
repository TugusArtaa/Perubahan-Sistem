@extends('layouts.app')

@section('title', 'Katalog Perubahan Sistem Aplikasi')

@section('header-title', 'Katalog Perubahan Sistem Aplikasi')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title p-2 bg-light">Identitas Sistem Aplikasi</h5>
            <div>
                <a href="{{ route('applications.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
                <a href="{{ route('applications.downloadPdf', $application->id) }}" class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Download as PDF
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 15%;">Nama</td>
                        <td style="width: 2%;">:</td>
                        <td>{{ $application->nama }}</td>
                    </tr>
                    <tr>
                        <td>Fungsi</td>
                        <td>:</td>
                        <td>{{ $application->fungsi }}</td>
                    </tr>
                    <tr>
                        <td>Pengguna</td>
                        <td>:</td>
                        <td>{{ $application->pengguna }}</td>
                    </tr>
                    <tr>
                        <td>Pemilik</td>
                        <td>:</td>
                        <td>{{ $application->pemilik }}</td>
                    </tr>
                    <tr>
                        <td>Pengembang</td>
                        <td>:</td>
                        <td>{{ $application->pengembang }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <h5 class="card-title p-2 bg-light">Perubahan Sistem Aplikasi</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th rowspan="2" style="vertical-align: middle;">Perubahan</th>
                            <th rowspan="2" style="vertical-align: middle;">Tingkat Kepentingan</th>
                            <th colspan="4">Tanggal Pelaksanaan Perubahan</th>
                            <th rowspan="2" style="vertical-align: middle;">Versi</th>
                            <th rowspan="2" style="vertical-align: middle;">Target Tanggal Release</th>
                        </tr>
                        <tr class="text-center">
                            <th>Tgl Permintaan</th>
                            <th>Tgl Persetujuan</th>
                            <th>Tgl UAT</th>
                            <th>Tgl Release</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($changes as $index => $change)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $change->perubahan }}</td>
                            <td>{{ $change->tingkat_kepentingan }}</td>
                            <td>{{ $change->request_date }}</td>
                            <td>{{ $change->approval_date }}</td>
                            <td>{{ $change->uat_date }}</td>
                            <td>{{ $change->release_date }}</td>
                            <td>{{ $change->version }}</td>
                            <td>{{ $change->target_release_date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data perubahan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection