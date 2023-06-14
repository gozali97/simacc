@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome back {{ Auth::user()->nama }}</h5>
                            <p class="mb-4">
                                Pemerintahan Desa Cibentang merupakan penyelenggara urusan pemerintahan dan kepentingan
                                masyarakat desa Cibentang dalam sistem pemerintahan. Pemerintahan desa cibentang bertanggung
                                jawab dalam menyelenggarakan pemerintahan dengan melayani masyarakat, melakukan pembangunan
                                dan pemberdayaan masyarakat.
                            </p>

                            {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="row">
            <div class="col-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-warning mb-2">Aset</h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $aset }}</h3>
                                </div>
                            </div>
                            <div><i class='fas fa-archive' style='font-size:36px'></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-success mb-2">Kaur</h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $kaur }}</h3>
                                </div>
                            </div>
                            <div><i class='fas fa-briefcase' style='font-size:36px'></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-info mb-2">User</h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $peminjam }}</h3>
                                </div>
                            </div>
                            <div><i class='fas fa-users' style='font-size:36px'></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-primary mb-2">Transaksi</h5>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $pinjam }}</h3>
                                </div>
                            </div>
                            <div><i class='fas fa-wallet' style='font-size:36px'></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
