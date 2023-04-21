@extends('layouts.app')

@section('content')
<div class="row p-3">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kaur /</span> Data Aset</h4>

    <div class="col-md-12">
        <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
            <div class="card mb-4 p-4">
                <h5 class="card-header">Tambah Aset</h5>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Aset</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Nama Aset" required />
                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Asal Aset</label>
                                <select name="asal" class="form-select @error('asal') is-invalid @enderror"
                                    id="exampleFormControlSelect1" aria-label="Default select example" required>
                                    <option value="">Pilih Asal Aset</option>
                                    @foreach ($asal as $a)
                                    <option value="{{ $a->id }}">{{ $a->asal_aset }}</option>
                                    @endforeach
                                </select>
                                @error('asal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Aset</label>
                                <select name="jenis" class="form-select @error('jenis') is-invalid @enderror"
                                    id="exampleFormControlSelect1" aria-label="Default select example" required>
                                    <option value="">Pilih Jenis Asett</option>
                                    @foreach ($jenis as $j)
                                    <option value="{{ $j->kd_jenis }}">{{ $j->nama_jenis }}</option>
                                    @endforeach
                                </select>
                                @error('jenis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah</label>
                                        <input name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                            type="number" id="html5-date-input" required />
                                        @error('jumlah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mt-4 mb-3" style="margin-top: 30px!important">
                                        <button id="buat-aset" type="button" class="btn rounded-pill btn-primary">
                                            <i class="tf-icons bx bx-cog" style="margin-right: 5px"></i>Generate
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="detail">
                <div class="card" style="background: transparent">

                </div>
            </div>
            <center class="mt-4">
                <div class="mb-3">
                    <a href="/aset" type="button" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </center>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
            const buatasetBtn = document.querySelector('#buat-aset');

            buatasetBtn.addEventListener('click', () => {

            const card = document.querySelector('#detail');
            buatasetBtn.setAttribute('disabled', true);

            const jumlah = parseInt(document.querySelector('input[name="jumlah"]').value);
            const cardBody = card.querySelector('.card');

            for (let i = 0; i < jumlah; i++) {
            const newCard = document.createElement('div');
            newCard.className = 'card mb-3';
            newCard.innerHTML = '<div class="card-header">Detail Aset</div><div class="card-body"><div class="row"><div class="col"><label class="form-label">Ruang</label><select id="ruang' + (i+1) + '" name="ruang[]"class="form-select @error('ruang') is-invalid @enderror" id="exampleFormControlSelect1" aria-label="Default select example" required> <option value="">Pilih Ruang</option> @foreach ($ruang as $r) <option value="{{ $r->kd_ruang }}">{{ $r->nama_ruang }}</option> @endforeach </select> @error('ruang') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> <div class="col"> <label class="form-label">Kondisi</label> <select id="kondisi' + (i+1) + '" name="kondisi[]" class="form-select @error('kondisi') is-invalid @enderror" id="exampleFormControlSelect1" aria-label="Default select example" required> <option value="">Pilih kondisi</option> @foreach ($kondisi as $k) <option value="{{ $k->id }}"> {{ $k->kondisi_aset }}</option> @endforeach </select> @error('kondisi') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div>  <div class="col"><label for="formFile" class="form-label">Foto</label> <input  class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar' + (i+1) + '" name="gambar[]" id="formFile" required /> @error('gambar') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div> </div> </div>';
            cardBody.appendChild(newCard);


            document.addEventListener("DOMContentLoaded", function() {
                // Kode Anda di sini
                document.getElementById(`gambar${i+1}`).addEventListener("change", function(event) {
                    if (document.getElementById(`gambar${i+1}`)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById(`preview${i+1}`).src = e.target.result;
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            });


                }

            });
        });
</script>

@endsection
