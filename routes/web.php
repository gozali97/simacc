<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisAsetController;
use App\Http\Controllers\KadesController;
use App\Http\Controllers\KaurController;
use App\Http\Controllers\KelolaKaurController;
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
});


Route::middleware(['auth', 'role:sekretaris'])->group(function () {
    Route::get('/sekretaris', [SekretarisController::class, 'index'])->name('sekretaris');

    //  Route Kelola Kaur
    Route::get('/kaurs', [KelolaKaurController::class, 'index'])->name('kaurs.index');
    Route::get('/kaurs/create', [KelolaKaurController::class, 'create'])->name('kaurs.create');
    Route::post('/kaurs/store', [KelolaKaurController::class, 'store'])->name('kaurs.store');
    Route::get('/kaurs/edit/{id}', [KelolaKaurController::class, 'edit'])->name('kaurs.edit');
    Route::post('/kaurs/update/{id}', [KelolaKaurController::class, 'update'])->name('kaurs.update');
    Route::get('/kaurs/destroy/{id}', [KelolaKaurController::class, 'destroy'])->name('kaurs.destroy');
    Route::post('/kaurs/reset-password/{id}', [KelolaKaurController::class, 'reset_password'])->name('kaurs.reset-password');

    //  Route Kelola Asset
    Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('/aset/create', [AsetController::class, 'create'])->name('aset.create');
    Route::post('/aset/store', [AsetController::class, 'store'])->name('aset.store');
    Route::get('/aset/edit/{id}', [AsetController::class, 'edit'])->name('aset.edit');
    Route::post('/aset/update/{id}', [AsetController::class, 'update'])->name('aset.update');
    Route::get('/aset/destroy/{id}', [AsetController::class, 'destroy'])->name('aset.destroy');

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
});


Route::middleware(['auth', 'role:kaur'])->group(function () {
    Route::get('/kaur', [KaurController::class, 'index'])->name('kaur');
});



