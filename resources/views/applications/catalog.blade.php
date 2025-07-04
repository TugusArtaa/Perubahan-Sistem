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
                        <td>No Kepdir</td>
                        <td>:</td>
                        <td>{{ $application->no_kepdir }}</td>
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
                <table class="table table-bordered table-sm" style="min-width: 900px; font-size: 0.95rem;">
                    <thead>
                        <tr class="text-center">
                            <th rowspan="2" style="vertical-align: middle; min-width: 40px;">No</th>
                            <th rowspan="2" style="vertical-align: middle; min-width: 180px;">Perubahan</th>
                            <th rowspan="2" style="vertical-align: middle; min-width: 120px;">Tingkat Kepentingan</th>
                            <th colspan="4" style="min-width: 400px;">Tanggal Pelaksanaan Perubahan</th>
                            <th rowspan="2" style="vertical-align: middle; min-width: 80px;">Versi</th>
                            <th rowspan="2" style="vertical-align: middle; min-width: 140px;">Target Tanggal Release</th>
                        </tr>
                        <tr class="text-center">
                            <th style="min-width: 120px;">Tgl Permintaan</th>
                            <th style="min-width: 120px;">Tgl Persetujuan</th>
                            <th style="min-width: 120px;">Tgl UAT</th>
                            <th style="min-width: 120px;">Tgl Release</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($changes as $index => $change)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $change->perubahan }}</td>
                            <td>{{ $change->tingkat_kepentingan }}</td>
                            <td>
                                @if($change->request_date_note)
                                    {!! nl2br(e($change->request_date_note)) !!}<br>
                                @endif
                                @if($change->request_date)
                                    <span>Tanggal: {{ \Carbon\Carbon::parse($change->request_date)->format('d F Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($change->approval_date_note)
                                    {!! nl2br(e($change->approval_date_note)) !!}<br>
                                @endif
                                @if($change->approval_date)
                                    <span>Tanggal: {{ \Carbon\Carbon::parse($change->approval_date)->format('d F Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($change->uat_date_note)
                                    {!! nl2br(e($change->uat_date_note)) !!}<br>
                                @endif
                                @if($change->uat_date)
                                    <span>Tanggal: {{ \Carbon\Carbon::parse($change->uat_date)->format('d F Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($change->release_date_note)
                                    {!! nl2br(e($change->release_date_note)) !!}<br>
                                @endif
                                @if($change->release_date)
                                    <span>Tanggal: {{ \Carbon\Carbon::parse($change->release_date)->format('d F Y') }}</span>
                                @endif
                            </td>
                            <td>{{ $change->version }}</td>
                            <td>
                                @if($change->target_release_date_note)
                                    {!! nl2br(e($change->target_release_date_note)) !!}<br>
                                @endif
                                @if($change->target_release_date)
                                    <span>Tanggal: {{ \Carbon\Carbon::parse($change->target_release_date)->format('d F Y') }}</span>
                                @endif
                            </td>
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