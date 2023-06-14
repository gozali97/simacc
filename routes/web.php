<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisAsetController;
use App\Http\Controllers\KadesController;
use App\Http\Controllers\KadesMasterController;
use App\Http\Controllers\KaurController;
use App\Http\Controllers\KelolaAjuanController;
use App\Http\Controllers\KelolaAsetController;
use App\Http\Controllers\KelolaKaurController;
use App\Http\Controllers\KelolaMutasiController;
use App\Http\Controllers\KelolaPeminjamanController;
use App\Http\Controllers\KelolaPengembalianController;
use App\Http\Controllers\KelolaPenghapusanController;
use App\Http\Controllers\KelolaPerencanaanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenghapusanController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\SekretarisController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class);


Route::middleware(['auth', 'role:kades'])->group(function () {
    Route::get('/kades', [KadesController::class, 'index'])->name('kades');
    Route::get('/kades/profile', [KadesController::class, 'profile'])->name('kades.profile');

    Route::get('/kades/laporan/aset', [LaporanController::class, 'aset'])->name('kades.laporan.aset');
    Route::post('/kades/laporan/aset/print', [LaporanController::class, 'asetPrint'])->name('kades.laporan.asetPrint');

    Route::get('/kades/laporan/user', [LaporanController::class, 'user'])->name('kades.laporan.user');
    Route::get('/kades/laporan/user/print', [LaporanController::class, 'userPrint'])->name('kades.laporan.userPrint');

    Route::get('/kades/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('kades.laporan.peminjaman');
    Route::post('/kades/laporan/peminjaman/print', [LaporanController::class, 'peminjamanPrint'])->name('kades.laporan.peminjamanPrint');

    Route::get('/kades/laporan/kembali', [LaporanController::class, 'kembali'])->name('kades.laporan.kembali');
    Route::post('/kades/laporan/kembali/print', [LaporanController::class, 'kembaliPrint'])->name('kades.laporan.kembaliPrint');

    Route::get('/kades/laporan/mutasi', [LaporanController::class, 'mutasi'])->name('kades.laporan.mutasi');
    Route::post('/kades/laporan/mutasi/print', [LaporanController::class, 'mutasiPrint'])->name('kades.laporan.mutasiPrint');

    Route::get('/kades/laporan/hapus', [LaporanController::class, 'hapus'])->name('kades.laporan.hapus');
    Route::post('/kades/laporan/hapus/print', [LaporanController::class, 'hapusPrint'])->name('kades.laporan.hapusPrint');

    Route::get('/kades/laporan/rencana', [LaporanController::class, 'rencana'])->name('kades.laporan.rencana');
    Route::post('/kades/laporan/rencana/print', [LaporanController::class, 'rencanaPrint'])->name('kades.laporan.rencanaPrint');


    Route::get('/kades/sekre', [KadesMasterController::class, 'index'])->name('kades.sekretaris');
    Route::get('/kades/kaur', [KadesMasterController::class, 'indexKaur'])->name('kades.sekretaris.kaur');
    Route::get('/kades/peminjam', [KadesMasterController::class, 'indexPeminjam'])->name('kades.sekretaris.peminjam');
    Route::get('/kades/sekre/create', [KadesMasterController::class, 'create'])->name('kades.sekretaris.create');
    Route::post('/kades/sekre/store', [KadesMasterController::class, 'store'])->name('kades.sekretaris.store');
    Route::get('/kades/sekre/edit/{id}', [KadesMasterController::class, 'edit'])->name('kades.sekretaris.edit');
    Route::post('/kades/sekre/update/{id}', [KadesMasterController::class, 'update'])->name('kades.sekretaris.update');
    Route::get('/kades/sekre/destroy/{id}', [KadesMasterController::class, 'destroy'])->name('kades.sekretaris.destroy');
    Route::post('/kades/sekre/reset-password/{id}', [KelolaKaurController::class, 'reset_password'])->name('kades.sekretaris.reset-password');
});


Route::middleware(['auth', 'role:sekretaris'])->group(function () {
    Route::get('/sekretaris', [SekretarisController::class, 'index'])->name('sekretaris');
    Route::get('/sekretaris/profile', [SekretarisController::class, 'profile'])->name('sekretaris.profile');

    //  Route Kelola Kaur
    Route::get('/kaurs', [KelolaKaurController::class, 'index'])->name('kaurs.index');
    Route::get('/kaurs/create', [KelolaKaurController::class, 'create'])->name('kaurs.create');
    Route::post('/kaurs/store', [KelolaKaurController::class, 'store'])->name('kaurs.store');
    Route::get('/kaurs/edit/{id}', [KelolaKaurController::class, 'edit'])->name('kaurs.edit');
    Route::post('/kaurs/update/{id}', [KelolaKaurController::class, 'update'])->name('kaurs.update');
    Route::get('/kaurs/destroy/{id}', [KelolaKaurController::class, 'destroy'])->name('kaurs.destroy');
    Route::post('/kaurs/reset-password/{id}', [KelolaKaurController::class, 'reset_password'])->name('kaurs.reset-password');

    //  Route Kelola Transaksi
    Route::get('/listpinjam', [KelolaPeminjamanController::class, 'index'])->name('listpinjam.index');
    Route::get('/listpinjam/view/{id}', [KelolaPeminjamanController::class, 'View'])->name('listpinjam.view');
    Route::post('/listpinjam/confirm/{id}', [KelolaPeminjamanController::class, 'confirm'])->name('listpinjam.confirm');
    Route::post('/listpinjam/decline/{id}', [KelolaPeminjamanController::class, 'decline'])->name('listpinjam.decline');
    Route::post('/listpinjam/store', [KelolaPeminjamanController::class, 'store'])->name('listpinjam.store');
    Route::get('/listpinjam/edit/{id}', [KelolaPeminjamanController::class, 'edit'])->name('listpinjam.edit');
    Route::post('/listpinjam/update/{id}', [KelolaPeminjamanController::class, 'update'])->name('listpinjam.update');
    Route::get('/listpinjam/destroy/{id}', [KelolaPeminjamanController::class, 'destroy'])->name('listpinjam.destroy');

    //  Route Kelola Transaksi
    Route::get('/listkembali', [KelolaPengembalianController::class, 'index'])->name('listkembali.index');
    Route::get('/listkembali/view/{id}', [KelolaPengembalianController::class, 'View'])->name('listkembali.view');
    Route::post('/listkembali/confirm/{id}', [KelolaPengembalianController::class, 'confirm'])->name('listkembali.confirm');
    Route::post('/listkembali/decline/{id}', [KelolaPengembalianController::class, 'decline'])->name('listkembali.decline');
    Route::post('/listkembali/store', [KelolaPengembalianController::class, 'store'])->name('listkembali.store');
    Route::get('/listkembali/edit/{id}', [KelolaPengembalianController::class, 'edit'])->name('listkembali.edit');
    Route::post('/listkembali/update/{id}', [KelolaPengembalianController::class, 'update'])->name('listkembali.update');
    Route::get('/listkembali/destroy/{id}', [KelolaPengembalianController::class, 'destroy'])->name('listkembali.destroy');

    //  Route Kelola Transaksi
    Route::get('/listmutasi', [KelolaMutasiController::class, 'index'])->name('listmutasi.index');
    Route::get('/listmutasi/view/{id}', [KelolaMutasiController::class, 'View'])->name('listmutasi.view');
    Route::post('/listmutasi/confirm/{id}', [KelolaMutasiController::class, 'confirm'])->name('listmutasi.confirm');
    Route::post('/listmutasi/decline/{id}', [KelolaMutasiController::class, 'decline'])->name('listmutasi.decline');
    Route::post('/listmutasi/store', [KelolaMutasiController::class, 'store'])->name('listmutasi.store');
    Route::get('/listmutasi/edit/{id}', [KelolaMutasiController::class, 'edit'])->name('listmutasi.edit');
    Route::post('/listmutasi/update/{id}', [KelolaMutasiController::class, 'update'])->name('listmutasi.update');
    Route::get('/listmutasi/destroy/{id}', [KelolaMutasiController::class, 'destroy'])->name('listmutasi.destroy');

    //  Route Kelola Transaksi
    Route::get('/listhapus', [KelolaPenghapusanController::class, 'index'])->name('listhapus.index');
    Route::get('/listhapus/view/{id}', [KelolaPenghapusanController::class, 'View'])->name('listhapus.view');
    Route::post('/listhapus/confirm/{id}', [KelolaPenghapusanController::class, 'confirm'])->name('listhapus.confirm');
    Route::post('/listhapus/cancel/{id}', [KelolaPenghapusanController::class, 'cancel'])->name('listhapus.cancel');
    Route::post('/listhapus/decline/{id}', [KelolaPenghapusanController::class, 'decline'])->name('listhapus.decline');
    Route::post('/listhapus/store', [KelolaPenghapusanController::class, 'store'])->name('listhapus.store');
    Route::get('/listhapus/edit/{id}', [KelolaPenghapusanController::class, 'edit'])->name('listhapus.edit');
    Route::post('/listhapus/update/{id}', [KelolaPenghapusanController::class, 'update'])->name('listhapus.update');
    Route::get('/listhapus/destroy/{id}', [KelolaPenghapusanController::class, 'destroy'])->name('listhapus.destroy');

    Route::get('/listaset', [KelolaAsetController::class, 'index'])->name('listaset.index');
    Route::get('/listaset/view/{id}', [KelolaAsetController::class, 'view'])->name('listaset.view');
    Route::get('/listaset/getDetailPinjam/{kd_peminjaman}', [KelolaAsetController::class, 'getDetailPinjam'])->name('listaset.getDetailPinjam');
    Route::post('/listaset/confirm/{id}', [KelolaAsetController::class, 'confirm'])->name('listaset.confirm');
    Route::post('/listaset/decline/{id}', [KelolaAsetController::class, 'decline'])->name('listaset.decline');
    Route::post('/listaset/store', [KelolaAsetController::class, 'store'])->name('listaset.store');
    Route::get('/listaset/edit/{id}', [KelolaAsetController::class, 'edit'])->name('listaset.edit');
    Route::post('/listaset/update/{id}', [KelolaAsetController::class, 'update'])->name('listaset.update');
    Route::get('/listaset/destroy/{id}', [KelolaAsetController::class, 'destroy'])->name('listaset.destroy');

    Route::get('/listajuan', [KelolaAjuanController::class, 'index'])->name('listajuan.index');
    Route::post('/listajuan/confirm/{id}', [KelolaAjuanController::class, 'confirm'])->name('listajuan.confirm');
    Route::post('/listajuan/cancel/{id}', [KelolaAjuanController::class, 'cancel'])->name('listajuan.cancel');
    Route::post('/listajuan/decline/{id}', [KelolaAjuanController::class, 'decline'])->name('listajuan.decline');
    Route::post('/listajuan/store', [KelolaAjuanController::class, 'store'])->name('listajuan.store');
    Route::get('/listajuan/edit/{id}', [KelolaAjuanController::class, 'edit'])->name('listajuan.edit');
    Route::post('/listajuan/update/{id}', [KelolaAjuanController::class, 'update'])->name('listajuan.update');
    Route::get('/listajuan/destroy/{id}', [KelolaAjuanController::class, 'destroy'])->name('listajuan.destroy');

    Route::get('/listrencana', [KelolaPerencanaanController::class, 'index'])->name('listrencana.index');
    Route::get('/listrencana/print', [KelolaPerencanaanController::class, 'print'])->name('listrencana.print');
});


Route::middleware(['auth', 'role:kaur'])->group(function () {
    Route::get('/kaur', [KaurController::class, 'index'])->name('kaur');
    Route::get('/kaur/profile', [KaurController::class, 'profile'])->name('kaur.profile');

    //  Route Kelola Asset
    Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('/aset/create', [AsetController::class, 'create'])->name('aset.create');
    Route::post('/aset/store', [AsetController::class, 'store'])->name('aset.store');
    Route::get('/aset/edit/{id}', [AsetController::class, 'edit'])->name('aset.edit');
    Route::get('/aset/view/{id}', [AsetController::class, 'view'])->name('aset.view');
    Route::post('/aset/update/{id}', [AsetController::class, 'update'])->name('aset.update');
    Route::post('/aset/updateDetail/{id}', [AsetController::class, 'updateDetail'])->name('aset.updateDetail');
    Route::get('/aset/destroy/{id}', [AsetController::class, 'destroy'])->name('aset.destroy');
    Route::post('/aset/destroy', [AsetController::class, 'destroyAset'])->name('aset.destroy.aset');

    //  Route Kelola Ruang
    Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
    Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang/store', [RuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/edit/{id}', [RuangController::class, 'edit'])->name('ruang.edit');
    Route::post('/ruang/update/{id}', [RuangController::class, 'update'])->name('ruang.update');
    Route::get('/ruang/destroy/{id}', [RuangController::class, 'destroy'])->name('ruang.destroy');

    //  Route Kelola Jenis Aset
    Route::get('/jenis', [JenisAsetController::class, 'index'])->name('jenis.index');
    Route::get('/jenis/create', [JenisAsetController::class, 'create'])->name('jenis.create');
    Route::post('/jenis/store', [JenisAsetController::class, 'store'])->name('jenis.store');
    Route::get('/jenis/edit/{id}', [JenisAsetController::class, 'edit'])->name('jenis.edit');
    Route::post('/jenis/update/{id}', [JenisAsetController::class, 'update'])->name('jenis.update');
    Route::get('/jenis/destroy/{id}', [JenisAsetController::class, 'destroy'])->name('jenis.destroy');

    //  Route Kelola Asset
    Route::get('/peminjam', [PeminjamController::class, 'index'])->name('peminjam.index');
    Route::get('/peminjam/create', [PeminjamController::class, 'create'])->name('peminjam.create');
    Route::post('/peminjam/store', [PeminjamController::class, 'store'])->name('peminjam.store');
    Route::get('/peminjam/edit/{id}', [PeminjamController::class, 'edit'])->name('peminjam.edit');
    Route::post('/peminjam/update/{id}', [PeminjamController::class, 'update'])->name('peminjam.update');
    Route::post('/peminjam/destroy/{id}', [PeminjamController::class, 'destroy'])->name('peminjam.destroy');

    //  Route Kelola peminjaman
    Route::get('/kaurmutasi', [MutasiController::class, 'index'])->name('kaurmutasi.index');
    Route::get('/kaurmutasi/view/{id}', [MutasiController::class, 'view'])->name('kaurmutasi.view');
    Route::post('/kaurmutasi/store', [MutasiController::class, 'store'])->name('kaurmutasi.store');
    Route::post('/kaurmutasi/insert', [MutasiController::class, 'insert'])->name('kaurmutasi.insert');
    Route::get('/kaurmutasi/edit/{id}', [MutasiController::class, 'edit'])->name('kaurmutasi.edit');
    Route::post('/kaurmutasi/update/{id}', [MutasiController::class, 'update'])->name('kaurmutasi.update');
    Route::get('/kaurmutasi/destroy/{id}', [MutasiController::class, 'destroy'])->name('kaurmutasi.destroy');

    //  Route Kelola peminjaman
    Route::get('/kaurpinjam', [PeminjamanController::class, 'index'])->name('kaurpinjam.index');
    Route::get('/kaurpinjam/create', [PeminjamanController::class, 'create'])->name('kaurpinjam.create');
    Route::get('/kaurpinjam/view/{id}', [PeminjamanController::class, 'view'])->name('kaurpinjam.view');
    Route::get('/kaurpinjam/getDetailAset', [PeminjamanController::class, 'getDetailAset'])->name('kaurpinjam.getDetailAset');
    Route::post('/kaurpinjam/store', [PeminjamanController::class, 'store'])->name('kaurpinjam.store');
    Route::post('/kaurpinjam/insert', [PeminjamanController::class, 'insert'])->name('kaurpinjam.insert');
    Route::get('/kaurpinjam/edit/{id}', [PeminjamanController::class, 'edit'])->name('kaurpinjam.edit');
    Route::post('/kaurpinjam/update/{id}', [PeminjamanController::class, 'update'])->name('kaurpinjam.update');
    Route::get('/kaurpinjam/destroy/{id}', [PeminjamanController::class, 'destroy'])->name('kaurpinjam.destroy');

    //  Route Kelola pengembalian
    Route::get('/kaurkembali', [PengembalianController::class, 'index'])->name('kaurkembali.index');
    Route::get('/kaurkembali/create', [PengembalianController::class, 'create'])->name('kaurkembali.create');
    Route::get('/kaurkembali/view/{id}', [PengembalianController::class, 'view'])->name('kaurkembali.view');
    Route::get('/kaurkembali/getDetailAset', [PengembalianController::class, 'getDetailAset'])->name('kaurkembali.getDetailAset');
    Route::post('/kaurkembali/store', [PengembalianController::class, 'store'])->name('kaurkembali.store');
    Route::get('/kaurkembali/edit/{id}', [PengembalianController::class, 'edit'])->name('kaurkembali.edit');
    Route::post('/kaurkembali/update/{id}', [PengembalianController::class, 'update'])->name('kaurkembali.update');
    Route::get('/kaurkembali/destroy/{id}', [PengembalianController::class, 'destroy'])->name('kaurkembali.destroy');

    //  Route Kelola penghapusan
    Route::get('/kaurhapus', [PenghapusanController::class, 'index'])->name('kaurhapus.index');
    Route::get('/kaurhapus/create', [PenghapusanController::class, 'create'])->name('kaurhapus.create');
    Route::get('/kaurhapus/view/{id}', [PenghapusanController::class, 'view'])->name('kaurhapus.view');
    Route::get('/kaurhapus/getDetailAset', [PenghapusanController::class, 'getDetailAset'])->name('kaurhapus.getDetailAset');
    Route::post('/kaurhapus/store', [PenghapusanController::class, 'store'])->name('kaurhapus.store');
    Route::get('/kaurhapus/edit/{id}', [PenghapusanController::class, 'edit'])->name('kaurhapus.edit');
    Route::post('/kaurhapus/update/{id}', [PenghapusanController::class, 'update'])->name('kaurhapus.update');
    Route::get('/kaurhapus/destroy/{id}', [PenghapusanController::class, 'destroy'])->name('kaurhapus.destroy');

    //  Route Kelola pengajuan
    Route::get('/kaurajuan', [PengajuanController::class, 'index'])->name('kaurajuan.index');
    Route::get('/kaurajuan/create', [PengajuanController::class, 'create'])->name('kaurajuan.create');
    Route::post('/kaurajuan/store', [PengajuanController::class, 'store'])->name('kaurajuan.store');
    Route::get('/kaurajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('kaurajuan.edit');
    Route::get('/kaurajuan/view/{id}', [PengajuanController::class, 'view'])->name('kaurajuan.view');
    Route::post('/kaurajuan/update/{id}', [PengajuanController::class, 'update'])->name('kaurajuan.update');
    Route::post('/kaurajuan/destroy/{id}', [PengajuanController::class, 'destroy'])->name('kaurajuan.destroy');
});
