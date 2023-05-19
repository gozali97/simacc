@extends('layouts.app')

@section('content')
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kaur /</span> Data Kaur</h4>

        <div class="col-md-12">
            <div class="card mb-4 p-4">
                <h5 class="card-header">Tambah Peminjaman</h5>
                <form action="{{ route('kaurpinjam.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Peminjam</label>
                            <select name="nama" class="form-select @error('aset') is-invalid @enderror"
                                id="exampleFormControlSelect1" aria-label="Default select example">
                                <option value="">Pilih Peminjam</option>
                                @foreach ($user as $u)
                                    <option value="{{ $u->id_peminjam }}">{{ $u->nama_peminjam }}</option>
                                @endforeach
                            </select>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Aset</label>
                                    <select id="aset" name="aset"
                                        class="form-select @error('aset') is-invalid @enderror"
                                        id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">Pilih Aset</option>
                                        @foreach ($aset as $a)
                                            <option value="{{ $a->kd_aset }}">{{ $a->nama_aset }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <h5 id="count">Jumlah Dipinjam</h5>
                                    <div class="table-responsive text-nowrap mt-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode Aset</th>
                                                    <th>Ruang</th>
                                                    <th>Kondisi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table" class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @error('aset')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <a href="/kaurpinjam" type="button" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#aset').on('change', function() {
                var kd_aset = $(this).val();
                $('#detailAset').empty();
                $.ajax({
                    type: 'get',
                    url: '{{ route('kaurpinjam.getDetailAset') }}',
                    data: {
                        'kd_aset': kd_aset
                    },
                    success: function(data) {
                        console.log(data);
                        showDetailAset(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            function showDetailAset(data) {
                var tableBody = $('#table');
                tableBody.empty();

                var count = 0;

                data.forEach(function(d) {
                    var row = $('<tr></tr>');
                    var td1 = $('<td></td>');
                    var checkbox = $('<input type="checkbox">')
                        .attr('name', 'detail[]')
                        .val(d.kd_det_aset)
                        .on('change', function() {
                            if ($(this).is(':checked')) {
                                count++;
                            } else {
                                count--;
                            }
                            $('#count').text('Jumlah Dipinjam: ' + count);
                        });
                    td1.append(checkbox);
                    var td2 = $('<td></td>').text(d.kode_detail);
                    var td3 = $('<td></td>').text(d.nama_ruang);
                    var td4 = $('<td></td>').text(d.kondisi_aset);

                    row.append(td1);
                    row.append(td2);
                    row.append(td3);
                    row.append(td4);

                    tableBody.append(row);
                });
            }

        });
    </script>
@endsection
