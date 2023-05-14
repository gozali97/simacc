@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                        Account</a></li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ url('/assets/img/' . $data->gambar) }}" alt="user-avatar" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" id="firstName" value="{{ $data->nama }}"
                                        name="firstName" value="John" autofocus="" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">No HP</label>
                                    <input class="form-control" type="text" name="lastName" value="{{ $data->no_hp }}"
                                        id="lastName" value="Doe" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="john.doe@example.com" placeholder="john.doe@example.com"
                                        value="{{ $data->email }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="organization" value="{{ $data->alamat }}"
                                        name="organization" value="ThemeSelection" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="my-0">
                {{-- <div class="card-body">
                    <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" id="firstName" name="firstName" value="John"
                                    autofocus="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">No HP</label>
                                <input class="form-control" type="text" name="lastName" id="lastName" value="Doe">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="john.doe@example.com" placeholder="john.doe@example.com">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="organization" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="organization" name="organization"
                                    value="ThemeSelection">
                            </div>
                        </div>
                    </form>
                </div> --}}
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection
