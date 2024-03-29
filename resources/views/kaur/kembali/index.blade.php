@extends('layouts.app')

@section('content')
@if(session('success'))
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
    $(document).ready(function(){
            setTimeout(function(){
                $(".bs-toast").alert('close');
            }, 5000);
        });
</script>
@endif

@if(session('error'))
<div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ session('error') }}
    </div>
</div>

<script>
    $(document).ready(function(){
            setTimeout(function(){
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
    $(document).ready(function(){
                setTimeout(function(){
                    $(".bs-toast").alert('close');
                }, 5000);
            });
</script>
@endif

<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengembalian /</span> List Pengembalian</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="p-3 mt-4">
            {{-- <h4 class="text-blue h4">Data Table Simple</h4> --}}
            <a href="/kaurpinjam" type="button" class="btn btn-outline-success">Tambah</a>
        </div>
        <div class="p-2">
            <table id="datatable" class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Tanggal Kembali</th>
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
                        <td>{{ date('d-m-Y', strtotime($a->tgl_kembali)) }}</td>
                        <td> <span class="badge
                            @if($a->status === 'Proses')
                                bg-primary
                            @elseif($a->status === 'Aktif')
                                bg-success
                            @elseif($a->status === 'Selesai')
                                bg-info
                            @else
                                bg-danger
                            @endif">
                                {{ $a->status }}
                            </span></span></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                <a href="{{ route('kaurkembali.view', $a->kd_peminjaman) }}" type="button" class="btn btn-icon btn-info">
                                    <span class="tf-icons bx bx-info-circle"></span>
                                </a>
                                @if ($a->status !== 'Aktif' && $a->status !== 'Ditolak')

                                {{-- <a href="#" class="btn btn-icon btn-danger"
                                    onclick="event.preventDefault(); confirmDelete('{{ $a->kd_peminjaman }}');">
                                    <i class="bx bx-trash"></i>
                                </a> --}}
                            </div>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="exLargeModal{{ $a->kd_peminjaman }}" tabindex="-1"
                        style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel4">Detail Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="nameExLarge" class="form-label">Nama Kaur</label>
                                            <input type="text" id="nameExLarge" class="form-control"
                                                value="{{ $a->nama }}" placeholder="Enter Name" disabled>
                                        </div>
                                        <div class="col mb-0">
                                            <label for="dobExLarge" class="form-label">Ruang</label>
                                            <input type="text" id="dobExLarge" class="form-control"
                                                value="{{ $a->ruang }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="emailExLarge" class="form-label">Nama Aset</label>
                                            <input type="text" id="emailExLarge" class="form-control"
                                                value="{{ $a->nama_aset }}" placeholder="xxxx@xxx.xx" disabled>
                                        </div>
                                        <div class="col mb-0">
                                            <div class="col mb-0">
                                                <label for="dobExLarge" class="form-label">Tanggal Pinjam</label>
                                                <input type="text" id="dobExLarge" class="form-control"
                                                    value="{{ date('Y-m-d', strtotime($a->tgl_pinjam)) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-0">
                                            <label for="emailExLarge" class="form-label">Jenis Aset</label>
                                            <input type="text" id="emailExLarge" class="form-control"
                                                value="{{ $a->jenis }}" placeholder="xxxx@xxx.xx" disabled>
                                        </div>
                                        <div class="col mb-0">
                                            <label for="dobExLarge" class="form-label">Status</label>
                                            <input type="text" id="dobExLarge" class="form-control"
                                                value="{{ $a->status }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-3">
                                        <div class="col mb-0">
                                            <label for="emailExLarge" class="form-label">Jumlah</label>
                                            <input type="text" id="emailExLarge" class="form-control"
                                                value="{{ $a->jml_peminjaman }}" placeholder="xxxx@xxx.xx" disabled>
                                        </div>
                                        <div class="col mb-0">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="emailExLarge" class="form-label mt-2">Gambar : </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <img src="{{ url('/assets/img/'.$a->gambar) }}" alt="user-avatar"
                                                        class="d-block rounded" height="100" width="100"
                                                        id="uploadedAvatar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
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
            window.location.href = "/kaurkembali/destroy/" + id;
        }
    });
}
</script>

@endsection
