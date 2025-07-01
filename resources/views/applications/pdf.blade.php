<!DOCTYPE html>
<html>

<head>
    <title>Katalog Perubahan Sistem Aplikasi</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        word-break: break-word;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .header-table td,
    .header-table th {
        border: 1px solid black;
        padding: 4px 8px;
        font-size: 13px;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }

    .header-logo {
        width: 80px;
        text-align: center;
        vertical-align: middle;
    }

    .header-title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        line-height: 1.3;
    }

    .header-meta {
        font-size: 12px;
        width: 180px;
    }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="header-logo" rowspan="4">
                {{-- Ganti path logo sesuai kebutuhan --}}
                <img src="{{ public_path('logo-bpd-bali.png') }}" alt="Logo BPD Bali" style="width:60px; height:auto;">
            </td>
            <td class="header-title" rowspan="2" colspan="3">
                STANDAR OPERASIONAL PROSEDUR<br>
                PT. BANK PEMBANGUNAN DAERAH BALI<br>
                <span style="font-size:14px;">PENGEMBANGAN DAN PENGADAAN TEKNOLOGI INFORMASI</span>
            </td>
            <td class="header-meta">Halaman : 1</td>
        </tr>
        <tr>
            <td class="header-meta">Kep. Dir : 0554/KEP/DIR/TI/2019</td>
        </tr>
        <tr>
            <td class="header-title" colspan="3" rowspan="2" style="font-size:15px;">
                Katalog Perubahan Sistem Aplikasi
            </td>
            <td class="header-meta">Tanggal : 17 – 09 – 2019</td>
        </tr>
        <tr>
            <td class="header-meta">Tanggal Revisi :</td>
        </tr>
    </table>

    <h2 style="margin-top: 10px;">Identitas Sistem Aplikasi</h2>
    <table>
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

    <h2>Perubahan Sistem Aplikasi</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Perubahan</th>
                    <th>Tingkat Kepentingan</th>
                    <th>Tgl Permintaan</th>
                    <th>Tgl Persetujuan</th>
                    <th>Tgl UAT</th>
                    <th>Tgl Release</th>
                    <th>Versi</th>
                    <th>Target Tanggal Release</th>
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
</body>

</html>