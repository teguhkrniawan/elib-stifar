<?php

use App\Http\Controllers\Buku\BukuController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Peminjaman\PeminjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Peminjaman Buku
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/keranjang', [PeminjamanController::class, 'indexKeranjang']);
Route::post('/peminjaman/insert', [PeminjamanController::class, 'insertPeminjaman']);
Route::get('/peminjaman/cetak', [PeminjamanController::class, 'cetakResi']);

// Mahasiswa
Route::post('/mahasiswa/detail', [MahasiswaController::class, 'detailMahasiswa']);

// Buku
Route::get('/buku/detail', [BukuController::class, 'getDetailBuku']);
