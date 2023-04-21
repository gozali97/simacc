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

<style>
    img {
        width: 70px;
        border-radius: 5%;
    }
</style>

<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kebutuhan /</span> List Kebutuhan</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="p-3 mt-4">
        </div>
        <div class="p-2">
            <table id="datatable" class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kebutuhan</th>
                        <th>Jumlah</th>
                        <th>Tanggal Kebutuhan</th>
                        <th>Gambar</th>
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
                        <td>{{ $d->nama_kebutuhan }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>{{ $d->tgl_kebutuhan }}</td>
                        <td>
                            <img src="{{ url('/assets/img/'.$d->gambar ) }}" alt="">
                        </td>
                        <td>

                            <span
                                class="badge @if($d->status == 'Proses') bg-label-warning @elseif($d->status == 'Disetujui') bg-label-success @else bg-label-danger @endif">{{
                                $d->status }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#exLargeModal{{ $d->kd_kebutuhan }}" class="btn btn-icon btn-info">
                                    <span class="tf-icons bx bx-info-circle bx-tada-hover"></span>
                                </button>
                                @if ($d->status == 'Proses')
                                <button data-bs-toggle="modal" data-bs-target="#confirmModal{{ $d->kd_kebutuhan }}"
                                    class="btn btn-icon btn-success">
                                    <i class="bx bx-check-square bx-tada-hover"></i>
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#declineModal{{ $d->kd_kebutuhan }}"
                                    class="btn btn-icon btn-danger">
                                    <i class="bx bx-x-circle bx-tada-hover"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <!-- Modal Info -->
                    <div class="modal fade" id="exLargeModal{{ $d->kd_kebutuhan }}" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel4">Detail Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kebutuhan</label>
                                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                                    placeholder="Nama kebutuhan" value="{{ $d->nama_kebutuhan }}" readonly/>
                                                @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah</label>
                                                <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                                    type="number" id="html5-date-input" value="{{ $d->jumlah }}" readonly/>
                                                @error('jumlah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Kebutuhan</label>
                                                <input type="date" name="tanggal"
                                                    class="form-control @error('tanggal') is-invalid @enderror" placeholder=""
                                                    value="{{ $d->tgl_kebutuhan }}" readonly/>
                                                @error('tanggal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img class="mt-4" id="preview" src="{{ url('/assets/img/', $d->gambar) }}" alt="">
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

                    <!-- Modal Konfirmasi -->
                    <div class="modal fade" id="confirmModal{{ $d->kd_kebutuhan }}"
                        aria-labelledby="modalToggleLabel{{ $d->kd_kebutuhan }}" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Kebutuhan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('listajuan.confirm',$d->kd_kebutuhan) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">Apakah Anda yakin ingin konfirmasi kebutuhan <span
                                            class="fw-bold">{{ $d->nama_aset }}</span>?</div>
                                    <input type="hidden" name="id_pinjam" value="{{ $d->kd_kebutuhan }}">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="declineModal{{ $d->kd_kebutuhan }}"
                        aria-labelledby="modalToggleLabel{{ $d->kd_kebutuhan }}" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Konfirmasi Kebutuhan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('listajuan.decline',$d->kd_kebutuhan) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">Apakah Anda yakin ingin tolak kebutuhan <span
                                            class="fw-bold">{{ $d->nama_aset }}</span>?</div>
                                    <input type="hidden" name="id_pinjam" value="{{ $d->kd_kebutuhan }}">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
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
