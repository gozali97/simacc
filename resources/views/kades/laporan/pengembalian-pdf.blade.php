<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengembalian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #dddddd;
        }

        .footer {
            text-align: left;
            float: right;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Data Pengembalian Aset</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
        @php
        $hitungKembali = \App\Models\DetailPengembalian::query()
                        ->join('pengembalian', 'pengembalian.kd_kembali', 'detail_pengembalian.kd_kembali')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count();
         $hitungselesai = \App\Models\DetailPengembalian::query()
                        ->join('pengembalian', 'pengembalian.kd_kembali', 'detail_pengembalian.kd_kembali')
                        ->where('pengembalian.status','Selesai')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count();
        $hitungproses = \App\Models\DetailPengembalian::query()
                        ->join('pengembalian', 'pengembalian.kd_kembali', 'detail_pengembalian.kd_kembali')
                        ->where('pengembalian.status','Proses')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count();
        @endphp
        <p>Jumlah Pengembalian : {{ $hitungKembali }}</p>
        <p>Jumlah pengembalian Selesai : {{ $hitungselesai }}</p>
        <p>Jumlah pengembalian Proses : {{ $hitungproses }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Ruang Aset</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="6" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->nama_jenis }}</td>
                        <td>{{ $d->nama_ruang }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_kembali)) }}</td>
                        <td>{{ $d->status }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="footer">
        <p>Brebes, {{ date('d F Y') }}</p>
        <p>Mengetahui, <br> Kepala Desa Cibentang</p>
        <br>
        <br>
        <p>yatno</p>
    </div>
</body>

</html>
