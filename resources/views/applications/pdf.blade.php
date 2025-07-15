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

    .text-wrap {
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-line;
    }

    @page {
        size: landscape;
    }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="header-logo" rowspan="4">
                <img src="{{ public_path('img/BPDLogo.png') }}" alt="Logo BPD Bali" style="width:60px; height:auto;">
            </td>
            <td class="header-title" rowspan="2" colspan="3">
                STANDAR OPERASIONAL PROSEDUR<br>
                PT. BANK PEMBANGUNAN DAERAH BALI<br>
                <span style="font-size:14px;">PENGEMBANGAN DAN PENGADAAN TEKNOLOGI INFORMASI</span>
            </td>
            <td class="header-meta">Halaman : 1</td>
        </tr>
        <tr>
            <td class="header-meta">Kep. Dir : {{ $application->no_kepdir }}</td>
        </tr>
        <tr>
            <td class="header-title" colspan="3" rowspan="2" style="font-size:15px;">
                Katalog Perubahan Sistem Aplikasi
            </td>
            <td class="header-meta">Tanggal : {{ \Carbon\Carbon::now()->format('d - m - Y') }}</td>
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

    <h2>Perubahan Sistem Aplikasi</h2>
    <div class="table-responsive" style="width:100%;overflow-x:auto;">
        <table style="width:100%; font-size: 11px;">
            <thead>
                <tr class="text-center">
                    <th rowspan="2" style="vertical-align: middle; white-space: nowrap; max-width: 55px; width: 55px;">No</th>
                    <th rowspan="2" style="vertical-align: middle; white-space: nowrap; max-width: 55px; width: 55px;">Perubahan
                    </th>
                    <th rowspan="2" style="vertical-align: middle; white-space: nowrap; max-width: 55px; width: 55px;">
                        Tingkat<br>Kepentingan
                    </th>
                    <th colspan="4" style="vertical-align: middle; white-space: nowrap;">Tanggal Pelaksanaan Perubahan</th>
                    <th rowspan="2" style="vertical-align: middle; white-space: nowrap; max-width: 55px; width: 55px;">Versi
                    </th>
                    <th rowspan="2" style="vertical-align: middle; max-width: 55px; width: 55px;">Target<br>Tanggal Release
                    </th>
                </tr>
                <tr class="text-center">
                    <th style="max-width: 55px; width: 55px;">Tgl<br>Permintaan</th>
                    <th style="max-width: 55px; width: 55px;">Tgl<br>Persetujuan</th>
                    <th style="max-width: 55px; width: 55px;">Tgl<br>UAT</th>
                    <th style="max-width: 55px; width: 55px;">Tgl<br>Release</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($changes as $index => $change)
                <tr>
                    <td class="text-center text-wrap" style="max-width: 55px; width: 55px;">{{ $index + 1 }}</td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">{{ $change->perubahan }}</td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">{{ $change->tingkat_kepentingan }}</td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">
                        @if($change->request_date_note)
                            {!! nl2br(e($change->request_date_note)) !!}<br>
                        @endif
                        @if($change->request_date)
                            <span>Tanggal: {{ \Carbon\Carbon::parse($change->request_date)->format('d F Y') }}</span>
                        @endif
                    </td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">
                        @if($change->approval_date_note)
                            {!! nl2br(e($change->approval_date_note)) !!}<br>
                        @endif
                        @if($change->approval_date)
                            <span>Tanggal: {{ \Carbon\Carbon::parse($change->approval_date)->format('d F Y') }}</span>
                        @endif
                    </td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">
                        @if($change->uat_date_note)
                            {!! nl2br(e($change->uat_date_note)) !!}<br>
                        @endif
                        @if($change->uat_date)
                            <span>Tanggal: {{ \Carbon\Carbon::parse($change->uat_date)->format('d F Y') }}</span>
                        @endif
                    </td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">
                        @if($change->release_date_note)
                            {!! nl2br(e($change->release_date_note)) !!}<br>
                        @endif
                        @if($change->release_date)
                            <span>Tanggal: {{ \Carbon\Carbon::parse($change->release_date)->format('d F Y') }}</span>
                        @endif
                    </td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">{{ $change->version }}</td>
                    <td class="text-wrap" style="max-width: 55px; width: 55px;">
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
                    <td colspan="9" class="text-center text-wrap">Tidak ada data perubahan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <style>
        @media print {
            table {
                table-layout: auto !important;
                font-size: 10px !important;
            }
            th, td {
                padding: 4px !important;
            }
            thead { 
                display: table-header-group;
                page-break-inside: avoid;
            }
            tbody {
                page-break-inside: auto;
            }
        }
        th[style*="white-space: nowrap;"] {
            white-space: nowrap !important;
        }
    </style>
</body>

</html>