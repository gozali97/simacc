@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengembalian /</span> Data Pengembalian</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="p-3 mt-4">
                <a href="{{ route('kades.laporan.kembaliPrint') }}" class="btn icon icon-left btn-primary">
                    <i class="bx bx-printer bx-tada-hover"></i> Cetak</a>
            </div>
            <div class="p-2">
                <table id="datatable" class="data-table table stripe hover nowrap">
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
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $a)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $a->nama_aset }}</td>
                                <td>{{ $a->nama_jenis }}</td>
                                <td>{{ $a->nama_ruang }}</td>
                                <td>{{ date('d-m-Y', strtotime($a->tgl_kembali)) }}</td>
                                <td> <span
                                        class="badge
                                @if ($a->status === 'Proses') bg-primary
                                @elseif($a->status === 'Aktif')
                                    bg-success
                                @elseif($a->status === 'Selesai')
                                    bg-info
                                @else
                                    bg-danger @endif">
                                        {{ $a->status }}
                                    </span></span></td>

                            </tr>

            </div>
        </div>
        @endforeach
        </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
