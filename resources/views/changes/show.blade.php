@extends('layouts.app')

@section('title', 'Detail Perubahan untuk ' . $change->application->nama)

@section('header-title', 'Perubahan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 style="color: #00A67C" class="mb-4">Detail Perubahan untuk {{ $change->application->nama }}</h4>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="perubahan" class="form-label">Perubahan:</label>
                            <textarea class="form-control" rows="4" readonly>{{ $change->perubahan }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tingkat_kepentingan" class="form-label">Tingkat Kepentingan:</label>
                            <input type="text" class="form-control" value="{{ ucfirst($change->tingkat_kepentingan) }}"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="approval_status" class="form-label">Status Persetujuan:</label>
                            <div class="form-control d-flex align-items-center" style="background-color: #f8f9fa;">
                                @php
                                    $status = $change->approval_status ?? 'pending';
                                @endphp
                                @if($status === 'approved')
                                    <span class="badge bg-success fs-6"><i class="bi bi-check-circle"></i> ✓ Disetujui</span>
                                @elseif($status === 'rejected')
                                    <span class="badge bg-danger fs-6"><i class="bi bi-x-circle"></i> ✗ Ditolak</span>
                                @else
                                    <span class="badge bg-warning fs-6"><i class="bi bi-clock"></i> ⏳ Menunggu Persetujuan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="request_date" class="form-label">Tanggal Permintaan:</label>
                            <input type="date" class="form-control" value="{{ $change->request_date }}" readonly>
                            <textarea class="form-control mt-1" rows="2" readonly>{{ $change->request_date_note }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="version" class="form-label">Versi:</label>
                            <input type="text" class="form-control" value="{{ $change->version }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="approval_date" class="form-label">Tanggal Persetujuan:</label>
                            <input type="date" class="form-control" value="{{ $change->approval_date }}" readonly>
                            <textarea class="form-control mt-1" rows="2" readonly>{{ $change->approval_date_note }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="uat_date" class="form-label">Tanggal UAT:</label>
                            <input type="date" class="form-control" value="{{ $change->uat_date }}" readonly>
                            <textarea class="form-control mt-1" rows="2" readonly>{{ $change->uat_date_note }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="release_date" class="form-label">Tanggal Rilis:</label>
                            <input type="date" class="form-control" value="{{ $change->release_date }}" readonly>
                            <textarea class="form-control mt-1" rows="2" readonly>{{ $change->release_date_note }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="target_release_date" class="form-label">Tanggal Rilis Target:</label>
                            <input type="date" class="form-control" value="{{ $change->target_release_date }}" readonly>
                            <textarea class="form-control mt-1" rows="2" readonly>{{ $change->target_release_date_note }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection