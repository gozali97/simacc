<!DOCTYPE html>
<html>

<head>
    <title>Laporan Mutasi</title>
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
    <h2 style="text-align:center;">Laporan Data Mutasi Aset</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} -
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
         @php
        $hitungmutasi = \App\Models\DetailMutasi::query()
                        ->join('mutasi', 'mutasi.kd_mutasi', 'detail_mutasi.kd_mutasi')
                        ->whereBetween('detail_mutasi.created_at', [$start, $end])
                        ->count();
         $hitungdisetujui = \App\Models\DetailMutasi::query()
                        ->join('mutasi', 'mutasi.kd_mutasi', 'detail_mutasi.kd_mutasi')
                        ->where('mutasi.status', 'Disetujui')
                        ->whereBetween('detail_mutasi.created_at', [$start, $end])
                        ->count();   
        $hitungditolak = \App\Models\DetailMutasi::query()
                        ->join('mutasi', 'mutasi.kd_mutasi', 'detail_mutasi.kd_mutasi')
                        ->where('mutasi.status', 'Ditolak')
                        ->whereBetween('detail_mutasi.created_at', [$start, $end])
                        ->count();  
        $hitungaktif = \App\Models\DetailMutasi::query()
                        ->join('mutasi', 'mutasi.kd_mutasi', 'detail_mutasi.kd_mutasi')
                        ->where('mutasi.status', 'Aktif')
                        ->whereBetween('detail_mutasi.created_at', [$start, $end])
                        ->count(); 
        @endphp
        <p>Jumlah Mutasi    : {{ $hitungmutasi }}</p>
        <p>Jumlah Mutasi Disetujui : {{ $hitungdisetujui }}</p>
        <p>Jumlah Mutasi Ditolak : {{ $hitungditolak }}</p>
        <p>Jumlah Mutasi Aktif : {{ $hitungaktif }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mutasi</th>
                <th>Tanggal Mutasi</th>
                <th>Nama Aset</th>
                <th>Ruang Aset</th>
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
                        <td>{{ $d->nama_mutasi }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_mutasi)) }}</td>
                        <td>{{ $d->nama_aset }}</td>
                        <td>{{ $d->nama_ruang }}</td>
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
        <p>Yatno</p>
    </div>
</body>

</html>
