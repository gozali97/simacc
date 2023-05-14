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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penghapusan Aset /</span> List Penghapusan</h4>

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
                            <th>Tanggal Pinjam</th>
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
                                <td>{{ date('d-m-Y', strtotime($a->tgl_penghapusan)) }}</td>
                                <td> <span
                                        class="badge
                            @if ($a->status === 'Aktif') bg-primary
                            @elseif($a->status === 'Disetujui')
                                bg-success
                            @else
                                bg-danger @endif">
                                        {{ $a->status }}
                                    </span></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <a href="{{ route('listhapus.view', $a->kd_penghapusan) }}" type="button"
                                            class="btn btn-icon btn-info detail-pinjam-btn"
                                            data-kd="{{ $a->kd_penghapusan }}">
                                            <span class="tf-icons bx bx-info-circle bx-tada-hover"></span>
                                        </a>
                                        @if ($a->status !== 'Disetujui' && $a->status !== 'Ditolak')
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#confirmModal{{ $a->kd_penghapusan }}"
                                                class="btn btn-icon btn-success">
                                                <i class="bx bx-check-square bx-tada-hover"></i>
                                            </button>
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#declineModal{{ $a->kd_penghapusan }}"
                                                class="btn btn-icon btn-danger">
                                                <i class="bx bx-x-circle bx-tada-hover"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Info -->

                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" id="confirmModal{{ $a->kd_penghapusan }}"
                                aria-labelledby="modalToggleLabel{{ $a->kd_penghapusan }}" tabindex="-1"
                                style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Penghapusan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('listhapus.confirm', $a->kd_penghapusan) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">Apakah Anda yakin ingin konfirmasi mutasi <span
                                                    class="fw-bold">{{ $a->nama_aset }}</span>?</div>
                                            <input type="hidden" name="kd_penghapusan" value="{{ $a->kd_penghapusan }}">
                                            <input type="hidden" name="kd_det_aset" value="{{ $a->kd_det_aset }}">
                                            <input type="hidden" name="kd_aset" value="{{ $a->kd_aset }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="declineModal{{ $a->kd_penghapusan }}"
                                aria-labelledby="modalToggleLabel{{ $a->kd_penghapusan }}" tabindex="-1"
                                style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Mutasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('listhapus.decline', $a->kd_penghapusan) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">Apakah Anda yakin ingin tolak mutasi <span
                                                    class="fw-bold">{{ $a->nama_aset }}</span>?</div>
                                            <input type="hidden" name="kd_penghapusan"
                                                value="{{ $a->kd_penghapusan }}">
                                            <input type="hidden" name="kd_det_aset" value="{{ $a->kd_det_aset }}">
                                            <input type="hidden" name="kd_aset" value="{{ $a->kd_aset }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                    window.location.href = "/listhapus/destroy/" + id;
                }
            });

            $('.detail-pinjam-btn').on('click', function() {
                var kdPeminjaman = $(this).data('kd');
                $.ajax({
                    url: "{{ route('listaset.getDetailPinjam', '') }}/" + kdPeminjaman,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableBody = '';
                        $.each(data, function(i, detail) {
                            tableBody += '<tr>' +
                                '<td>' + detail.kode_inventory + '</td>' +
                                '<td>' + detail.nama_aset + '</td>' +
                                '<td>' + detail.nama_ruang + '</td>' +
                                '<td>' + detail.jenis_aset + '</td>' +
                                '</tr>';
                        });
                        $('#detail-pinjam table tbody').html(tableBody);
                    },
                    error: function() {
                        alert('Gagal mengambil data detail pinjam!');
                    }
                });
            });
        }
    </script>
@endsection
