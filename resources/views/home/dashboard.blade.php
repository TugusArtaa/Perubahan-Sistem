@extends('layouts.app')

@section('title', 'Dashboard')

@section('header-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Aplikasi</h6>
                            <h3 class="mb-0">{{ $totalApplications }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-window text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Perubahan</h6>
                            <h3 class="mb-0">{{ $totalChanges }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-gear text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Normal</h6>
                            <h3 class="mb-0">{{ $normalChanges }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Mendesak</h6>
                            <h3 class="mb-0">{{ $urgentChanges }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Changes Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Perubahan Terbaru</h5>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Cari perubahan..." id="searchChanges">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Aplikasi</th>
                            <th>Perubahan</th>
                            <th>Status</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="changesTableBody">
                        @foreach($recentChanges as $change)
                        <tr>
                            <td>{{ $change->application->nama }}</td>
                            <td>{{ $change->perubahan }}</td>
                            <td><span
                                    class="badge bg-{{ $change->tingkat_kepentingan == 'Mendesak' ? 'warning' : ($change->tingkat_kepentingan == 'Normal' ? 'info' : 'success') }}">{{ ucfirst($change->tingkat_kepentingan) }}</span>
                            </td>
                            <td>{{ $change->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('changes.show', ['application' => $change->application_id, 'change' => $change->id]) }}"
                                    class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $recentChanges->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchChanges').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#changesTableBody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

@endsection