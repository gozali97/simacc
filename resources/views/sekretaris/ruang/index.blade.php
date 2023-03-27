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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ruang /</span> Data Ruang</h4>

    <!-- Basic Bootstrap Table -->
    <div id="loading">

    </div>
    <div class="col-md-6">
        <div class="card mb-4 p-4">
            <div class="p-3 mt-4">
                <h4 class="text-blue h4">Data Ruang</h4>
                {{-- <a href="/ruang/create" type="button" class="btn btn-outline-success">Tambah</a> --}}
            </div>

            <div class="table-responsive text-nowrap">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruang</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($ruang as $r)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $r->nama_ruang }}</td>
                            <td>
                                <button type="button" class="btn btn-icon btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter{{ $r->kd_ruang }}">
                                    <i class="bx bx-edit-alt" aria-hidden="true"></i>
                                </button>
                                <a href="#" class="btn btn-icon btn-danger"
                                    onclick="event.preventDefault(); confirmDelete({{ $r->kd_ruang }});">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Update -->
                        <!-- Modal -->
                        <div class="modal fade" id="modalCenter{{ $r->kd_ruang }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Ubah Ruang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('ruang.update', ['id' => $r->kd_ruang]) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="nama" class="form-label">Nama Ruang</label>
                                                    <input type="nama" name="nama" id="nama" class="form-control"
                                                        value="{{ $r->nama_ruang }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4 p-4">
            <h5 class="card-header">Tambah Ruang</h5>
            <form id="tambah-ruang-form" action="{{ route('ruang.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Ruang" />
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    var table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('ruang.index') }}",
        "columns": [
            { "data": "nama_ruang" },
            { "data": "action", "orderable": false, "searchable": false },
        ]
    });

    $(function() {
    $('#tambah-ruang-form').on('submit', function(e) {
        e.preventDefault(); // mencegah halaman memuat ulang saat formulir dikirim

        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = new FormData(this);

        $.ajax({
            url: url,
            method: method,
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Menampilkan spinner sebelum mengirim data
                $('#loading').show();
            },
            success: function(response) {
                // Mengosongkan formulir setelah berhasil menambahkan data
                form.trigger('reset');
                // Menambahkan data baru ke dalam tabel
                var table = $('#datatable').DataTable();
                table.row.add([
                    response.nama_ruang,
                    '<a href="/ruang/' + response.kd_ruang + '/edit" type="button" class="btn btn-icon btn-warning"><span class="tf-icons bx bx-edit-alt"></span></a>' +
                    '<a href="#" class="btn btn-icon btn-danger" onclick="event.preventDefault(); confirmDelete(' +
                    response.kd_ruang + ');"><i class="bx bx-trash"></i></a>',
                ]).draw(false);
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON.errors;
                var errorMsg = '';
                $.each(errors, function(key, value) {
                    errorMsg += value[0] + '<br>';
                });
                alert(errorMsg);
            },
            complete: function() {
                // Menutup spinner setelah selesai mengirim data
                setTimeout(function() {
                    $('#loading').hide();
                }, 2000);
            }
        });
    });
});
});

</script>

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
            window.location.href = "/ruang/destroy/" + id;
        }
    });
}
</script>

@endsection
