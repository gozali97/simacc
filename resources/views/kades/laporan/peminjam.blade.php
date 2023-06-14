@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="bs-toast toast fade show bg-success" role="alert" style="width: 100%!important;" aria-live="assertive"
            aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".bs-toast").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if (session('error'))
        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".bs-toast").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".bs-toast").alert('close');
                }, 5000);
            });
        </script>
    @endif

    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Peminjam /</span> Data Peminjam</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="p-3 mt-4">
                <a href="{{ route('kades.laporan.userPrint') }}" class="btn icon icon-left btn-primary">
                    <i class="bx bx-printer bx-tada-hover"></i> Cetak</a>
            </div>
            <div class="p-2">
                <table id="datatable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Gambar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $d->nama_peminjam }}</td>
                                <td>{{ $d->alamat }}</td>
                                <td>{{ $d->no_hp }}</td>
                                <td><img src="{{ url('assets/img/' . $d->gambar) }}"
                                        style="width:80px; height:80px;border-radius: 70%;" alt=""></td>
                                <td>
                                     @if ($d->status == '1')
                                <span class="badge rounded-pill bg-label-success">Aktif</span>
                                @else
                                <span class="badge rounded-pill bg-label-danger">Tidak Aktif</span>
                                @endif
                                </td>
                            </tr>

            </div>
        </div>
        @endforeach
        </tbody>
        </table>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        function confirmDelete(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke route untuk menghapus data dengan ID yang telah ditentukan
                    window.location.href = "/peminjam/destroy/" + id;
                }
            });
        }
    </script>
@endsection
