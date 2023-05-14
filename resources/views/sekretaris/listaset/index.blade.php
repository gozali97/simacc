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

    <style>
        img {
            width: 70px;
            border-radius: 5%;
        }
    </style>

    <div class="row p-3">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Aset /</span> List Aset</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="p-3 mt-4">
            </div>
            <div class="p-2">
                <table id="datatable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aset</th>
                            <th>Asal</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $d->nama_aset }}</td>
                                <td>{{ $d->asal_aset }}</td>
                                <td>{{ $d->nama_jenis }}</td>
                                <td>

                                    <span
                                        class="badge @if ($d->status == 'Pending') bg-label-warning @elseif($d->status == 'Aktif') bg-label-success @else bg-label-danger @endif">{{ $d->status }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <a href="{{ route('listaset.view', $d->kd_aset) }}" type="button"
                                            class="btn btn-icon btn-info">
                                            <span class="tf-icons bx bx-info-circle bx-tada-hover"></span>
                                        </a>
                                        @if ($d->status == 'Pending')
                                            <button data-bs-toggle="modal" data-bs-target="#confirmModal{{ $d->kd_aset }}"
                                                class="btn btn-icon btn-success">
                                                <i class="bx bx-check-square bx-tada-hover"></i>
                                            </button>
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#declineModal{{ $d->kd_aset }}"
                                                class="btn btn-icon btn-danger">
                                                <i class="bx bx-x-circle bx-tada-hover"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" id="confirmModal{{ $d->kd_aset }}"
                                aria-labelledby="modalToggleLabel{{ $d->kd_aset }}" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Aset</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('listaset.confirm', $d->kd_aset) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">Apakah Anda yakin ingin konfirmasi aset <span
                                                    class="fw-bold">{{ $d->nama_aset }}</span>?</div>
                                            <input type="hidden" name="id_pinjam" value="{{ $d->kd_aset }}">
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

                            <div class="modal fade" id="declineModal{{ $d->kd_aset }}"
                                aria-labelledby="modalToggleLabel{{ $d->kd_aset }}" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Aset</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('listaset.decline', $d->kd_aset) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">Apakah Anda yakin ingin tolak kebutuhan <span
                                                    class="fw-bold">{{ $d->nama_aset }}</span>?</div>
                                            <input type="hidden" name="id_pinjam" value="{{ $d->kd_aset }}">
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
                    window.location.href = "/kaurpinjam/destroy/" + id;
                }
            });
        }
    </script>
@endsection
