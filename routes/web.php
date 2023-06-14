<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaBukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ManageAnggotaController;
use App\Http\Controllers\ManageLaporanController;
use App\Http\Controllers\ManagePengembalianController;
use App\Http\Controllers\ManagePetugasController;
use App\Http\Controllers\ManagePinjamController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PustakaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

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
Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
Route::post('/profil/update/{id}', [HomeController::class, 'update'])->name('profile.update');
Route::resource('roles', RoleController::class);

// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::controller(ManageLaporanController::class)->group(function () {
        Route::get('admin/laporan', 'index')->name('laporan.index');
        Route::get('admin/print', 'print')->name('laporan.print');
    });

    Route::controller(ManagePetugasController::class)->group(function () {
        Route::get('listpetugas', 'index')->name('petugas.index');
        Route::post('listpetugas/store', 'store')->name('petugas.store');
        Route::post('listpetugas/update/{id}', 'update')->name('petugas.update');
        Route::post('listpetugas/destroy/{id}', 'destroy')->name('petugas.destroy');
        Route::post('/listpetugas/reset-password/{id}', 'resetPassword')->name('petugas.resetPassword');
    });
});


Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');

    Route::controller(KategoriController::class)->group(function () {
        Route::get('kategori', 'index')->name('kategori.index');
        Route::post('kategori/store', 'store')->name('kategori.store');
        Route::post('kategori/update/{id}', 'update')->name('kategori.update');
        Route::post('kategori/destroy/{id}', 'destroy')->name('kategori.destroy');
    });

    Route::controller(PengarangController::class)->group(function () {
        Route::get('pengarang', 'index')->name('pengarang.index');
        Route::post('pengarang/store', 'store')->name('pengarang.store');
        Route::post('pengarang/update/{id}', 'update')->name('pengarang.update');
        Route::post('pengarang/destroy/{id}', 'destroy')->name('pengarang.destroy');
    });

    Route::controller(PenerbitController::class)->group(function () {
        Route::get('penerbit', 'index')->name('penerbit.index');
        Route::post('penerbit/store', 'store')->name('penerbit.store');
        Route::post('penerbit/update/{id}', 'update')->name('penerbit.update');
        Route::post('penerbit/destroy/{id}', 'destroy')->name('penerbit.destroy');
    });

    Route::controller(ManageAnggotaController::class)->group(function () {
        Route::get('users', 'index')->name('users.index');
        Route::post('users/store', 'store')->name('users.store');
        Route::post('users/update/{id}', 'update')->name('users.update');
        Route::post('users/destroy/{id}', 'destroy')->name('users.destroy');
        Route::post('/users/reset-password/{id}', 'resetPassword')->name('users.resetPassword');
    });

    Route::controller(PustakaController::class)->group(function () {
        Route::get('pustaka', 'index')->name('pustaka.index');
        Route::post('pustaka/store', 'store')->name('pustaka.store');
        Route::post('pustaka/update/{id}', 'update')->name('pustaka.update');
        Route::post('pustaka/destroy/{id}', 'destroy')->name('pustaka.destroy');
    });

    Route::controller(ManagePinjamController::class)->group(function () {
        Route::get('listpinjam', 'index')->name('listpinjam.index');
        Route::get('listpinjam/sync', 'sync')->name('listpinjam.sync');
        Route::get('listpinjam/detail/{id}', 'view')->name('listpinjam.view');
        Route::get('listpinjam/accpinjam/{id}', 'accPinjam')->name('listpinjam.accPinjam');
        Route::post('listpinjam/store', 'store')->name('listpinjam.store');
        Route::post('listpinjam/storeAll', 'storeAll')->name('listpinjam.storeAll');
        Route::post('listpinjam/insert', 'insert')->name('listpinjam.insert');
        Route::post('listpinjam/update/{id}', 'update')->name('listpinjam.update');
        Route::post('listpinjam/destroy/{id}', 'destroy')->name('listpinjam.destroy');
        Route::post('listpinjam/destroyy/{id}', 'destroyy')->name('listpinjam.destroyy');
    });

    Route::controller(ManagePengembalianController::class)->group(function () {
        Route::get('listkembali', 'index')->name('listkembali.index');
        Route::post('listkembali/view/{id}', 'view')->name('listkembali.view');
        Route::get('listkembali/detail/{no_kembali}', 'detail')->name('listkembali.detail');
    });

    Route::controller(ManageLaporanController::class)->group(function () {
        Route::get('laporan', 'index')->name('laporan.index');
        Route::get('laporanPustaka', 'indexPustaka')->name('laporan.indexPustaka');
        Route::get('printPustaka', 'printPustaka')->name('laporan.printPustaka');
        Route::post('print', 'printByMonth')->name('laporan.print');
        Route::get('laporanPinjam', 'indexPinjam')->name('laporan.indexPinjam');
        Route::post('printPinjam', 'printPinjam')->name('laporan.printPinjam');
        Route::get('laporanDenda', 'indexDenda')->name('laporan.indexDenda');
        Route::post('printDenda', 'printDenda')->name('laporan.printDenda');
    });
});


Route::middleware(['auth', 'role:anggota'])->group(function () {
    // Route::get('/anggota', [AdminController::class, 'index'])->name('anggota');
    Route::controller(AnggotaController::class)->group(function () {
        Route::get('/anggota', 'index')->name('anggota');
        // Route::get('/anggota/profil/{id}', 'profil')->name('anggota.profil');
        Route::post('/anggota/update/{id}', 'update')->name('anggota.update');
    });

    Route::controller(AnggotaBukuController::class)->group(function () {
        Route::get('/list', 'index')->name('list.index');
        Route::get('/list/detail/{id}', 'detail')->name('detail.profil');
        Route::post('/list/store/{id}', 'store')->name('store.update');
        Route::get('/get-pustaka', 'getPustaka')->name('list.pustaka');
    });

    Route::controller(PeminjamanController::class)->group(function () {
        Route::post('/pinjam/store', 'store')->name('pinjam.store');
        Route::get('/pinjam/list/', 'index')->name('pinjam.index');
        Route::post('/list/store/{id}', 'store')->name('store.update');
    });
});
