<!DOCTYPE html>
<html>

<head>
    <title>Katalog Perubahan Sistem Aplikasi</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
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
    </style>
</head>

<body>
    <h2>Identitas Sistem Aplikasi</h2>
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
</body>

</html>