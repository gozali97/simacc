<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img src="{{ url('assets/img/logo.png') }}" style="width: 40px" alt="">
            <span class="text-lg demo menu-text fw-bolder ms-2">SIMAC</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @auth
        <!-- Dashboard -->
        @if (Auth::user()->role->name === 'kades')
        <li class="menu-item active">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Master</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="layouts-without-menu.html" class="menu-link">
                        <div data-i18n="Without menu">Data User</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li>
        @elseif (Auth::user()->role->name === 'sekretaris')
        <li class="menu-item {{ request()->is('sekretaris*') ? 'active' : '' }}">
            <a href="/sekretaris" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle bx-tada-hover"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ request()->is('listaset*') ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Layouts">Master Data</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/listaset" class="menu-link">
                        <div data-i18n="Without menu">Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/listmutasi" class="menu-link">
                        <div data-i18n="Without menu">Mutasi</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle {{ request()->is('listpinjam*') || request()->is('jenis*') || request()->is('asset*') ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-cart-alt bx-tada-hover"></i>
                <div data-i18n="Layouts">Transaksi</div>
            </a>

            <ul class="menu-sub">
                </li>
                <li class="menu-item">
                    <a href="/listpinjam" class="menu-link">
                        <div data-i18n="Without menu">Peminjaman</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/listkembali" class="menu-link">
                        <div data-i18n="Without menu">Pengembalian</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/listajuan" class="menu-link">
                        <div data-i18n="Without menu">Kebutuhan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/listrencana" class="menu-link">
                        <div data-i18n="Without menu">Perencanaan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('kaurs*') ? 'active' : '' }}">
            <a href="/kaurs" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user bx-tada-hover"></i>
                <div data-i18n="Analytics">Manajemen Kaur</div>
            </a>
        </li>
        @elseif (Auth::user()->role->name === 'kaur')
        <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('ruang*') || request()->is('jenis*')|| request()->is('peminjam*') || request()->is('asset*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-archive bx-tada-hover"></i>
                <div data-i18n="Layouts">Master</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/jenis" class="menu-link">
                        <div data-i18n="Without menu">Data Jenis Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/ruang" class="menu-link">
                        <div data-i18n="Without menu">Data Ruang</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/aset" class="menu-link">
                        <div data-i18n="Without menu">Data Aset</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/peminjam" class="menu-link">
                        <div data-i18n="Without menu">Data Peminjam</div>
                    </a>
                </li>
            </ul>
        </li>
         <li class="menu-item {{ request()->is('kaurpinjam*') || request()->is('kaurkembali*') || request()->is('kaurhapus*')  || request()->is('kaurmutasi*')  || request()->is('kaurajuan*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Layouts">Transaksi</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="/kaurpinjam" class="menu-link">
                        <div data-i18n="Without menu">Peminjaman</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/kaurkembali" class="menu-link">
                        <div data-i18n="Without menu">Pengembalian</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/kaurmutasi" class="menu-link">
                        <div data-i18n="Without menu">Mutasi</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/kaurhapus" class="menu-link">
                        <div data-i18n="Without menu">Penghapusan</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/kaurajuan" class="menu-link">
                        <div data-i18n="Without menu">Kebutuhan</div>
                    </a>
                </li>
            </ul>

        </li>
        {{-- <li class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
            <a href="/laporan" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li> --}}
        @endif
        <li class="menu-item">
            <a href="#" class="menu-link" onclick="event.preventDefault(); Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan keluar dari web!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });">
            <i class="menu-icon tf-icons bx bx-log-out bx-tada-hover"></i>
            <div>Logout</div>
        </a>

        </li>
        @else
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
        @endauth
    </ul>
</aside>
