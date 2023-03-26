<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ManageAnggotaController;
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
Route::resource('roles', RoleController::class);

// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

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
});


Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/anggota', [AdminController::class, 'index'])->name('anggota');
});

