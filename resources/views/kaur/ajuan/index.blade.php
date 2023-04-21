@extends('layouts.app')

@section('content')
<style>
    img{
        border-radius: 5%;
        width: 70px;

    }
</style>

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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kebutuhan /</span> Data Kebutuhan</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="p-3 mt-4">
            {{-- <h4 class="text-blue h4">Data Table Simple</h4> --}}
            <a href="/kaurajuan/create" type="button" class="btn btn-outline-success">Tambah</a>
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

                            <span class="badge @if($d->status == 'Proses') bg-label-warning @elseif($d->status == 'Disetujui') bg-label-success @else bg-label-danger @endif">{{ $d->status }}</span></td>
                        <td>
                            @if($d->status == 'Proses')
                            <a href="{{ route('kaurajuan.edit', $d->kd_kebutuhan) }}" type="button" class="btn btn-icon btn-warning">
                                <span class="tf-icons bx bx-edit-alt"></span>
                            </a>
                            <button data-bs-toggle="modal" data-bs-target="#deleteModal{{ $d->kd_kebutuhan}}"
                                class="btn btn-icon btn-danger">
                                <i class="bx bx-trash bx-tada-hover"></i>
                            </button>
                            @else
                            <span class="badge bg-label-primary">
                                Selesai
                            </span>
                            @endif

                        </td>
                    </tr>
                    <div class="modal fade" id="deleteModal{{ $d->kd_kebutuhan }}"
                        aria-labelledby="modalToggleLabel{{ $d->kd_kebutuhan }}" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Hapus Kebutuhan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('kaurajuan.destroy',$d->kd_kebutuhan) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="modal-body">Apakah Anda yakin ingin hapus <span class="fw-bold">{{ $d->nama_kebutuhan }}</span>?</div>
                                <input type="hidden" name="id_pinjam" value="{{ $d->kd_aset }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
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

    function confirmDelete(kd_aset) {
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
            window.location.href = "/kaurajuan/destroy/" + kd_aset;
        }
    });
}
</script>

@endsection
