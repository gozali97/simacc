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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penghapusan /</span> List Penghapusan</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="p-3 mt-4">
                {{-- <h4 class="text-blue h4">Data Table Simple</h4> --}}
                {{-- <a href="/kaurpinjam/create" type="button" class="btn btn-outline-success">Tambah</a> --}}
            </div>
            <div class="p-2">
                <table id="datatable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Tanggal Penghapusan</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                <td>{{ $a->jenis }}</td>
                                <td>{{ date('d-m-Y', strtotime($a->tgl_penghapusan)) }}</td>
                                <td> <span
                                        class="badge
                            @if ($a->status === 'Proses') bg-primary
                            @elseif($a->status === 'Disetujui')
                                bg-success
                            @elseif($a->status === 'Selesai')
                                bg-info
                            @else
                                bg-danger @endif">
                                        {{ $a->status }}
                                    </span></span></td>
                                <td>
                                    @if ($a->status == 'Disetujui')
                                        <div class="btn-group" role="group" aria-label="First group">
                                            <a href="{{ route('kaurhapus.view', $a->kd_penghapusan) }}" type="button"
                                                class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-info-circle"></span>
                                            </a>
                                            {{-- <button data-bs-toggle="modal"
                                                data-bs-target="#confirmModal{{ $a->kd_penghapusan }}" type="button"
                                                class="btn btn-icon btn-success">
                                                <span class="tf-icons bx bx-analyse bx-tada-hover"></span>
                                            </button> --}}
                                        </div>
                                    @elseif ($a->status == 'Proses')
                                        <div class="btn-group" role="group" aria-label="First group">
                                            <a href="{{ route('kaurhapus.view', $a->kd_penghapusan) }}" type="button"
                                                class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-info-circle"></span>
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('kaurhapus.view', $a->kd_penghapusan) }}" type="button"
                                            class="btn btn-icon btn-info">
                                            <span class="tf-icons bx bx-info-circle"></span>
                                        </a>
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
                    window.location.href = "/kaurpinjam/destroy/" + id;
                }
            });
        }
    </script>
@endsection
