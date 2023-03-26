<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KadesController;
use App\Http\Controllers\KaurController;
use App\Http\Controllers\KelolaKaurController;
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

    Route::get('/kaurs', [KelolaKaurController::class, 'index'])->name('kaurs.index');
    Route::get('/kaurs/create', [KelolaKaurController::class, 'create'])->name('kaurs.create');
    Route::post('/kaurs/store', [KelolaKaurController::class, 'store'])->name('kaurs.store');
    Route::get('/kaurs/edit/{id}', [KelolaKaurController::class, 'edit'])->name('kaurs.edit');
    Route::post('/kaurs/update/{id}', [KelolaKaurController::class, 'update'])->name('kaurs.update');
    Route::get('/kaurs/destroy/{id}', [KelolaKaurController::class, 'destroy'])->name('kaurs.destroy');
    Route::post('/kaurs/reset-password/{id}', [KelolaKaurController::class, 'reset_password'])->name('kaurs.reset-password');
});


Route::middleware(['auth', 'role:kaur'])->group(function () {
    Route::get('/kaur', [KaurController::class, 'index'])->name('kaur');
});



