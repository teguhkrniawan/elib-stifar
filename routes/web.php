<?php

use App\Http\Controllers\Buku\BukuController;
use App\Http\Controllers\Denda\DendaController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Peminjaman\PeminjamanController;
use App\Http\Controllers\Pengembalian\PengembalianController;
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

// Denda 
Route::get('/denda', [DendaController::class, 'index']);
Route::post('/denda/cekmhs', [DendaController::class, 'cekDenda']);
Route::get('/denda/pay', [DendaController::class, 'indexPay']);
Route::get('/denda/cetak', [DendaController::class, 'cetak']);

// email
Route::get('/mail-test', [DendaController::class, 'sendMail']);

// pengembalian 
Route::get('/pengembalian', [PengembalianController::class, 'index']);
Route::post('/pengembalian/cek', [PengembalianController::class, 'cekPeminjaman']);
Route::get('/pengembalian/keranjang', [PengembalianController::class, 'indexKeranjang']);
Route::get('/pengembalian/cekbuku', [PengembalianController::class, 'cekbuku']);
Route::post('/pengembalian/insert', [PengembalianController::class, 'insert']);
Route::get('/pengembalian/cetak', [PengembalianController::class, 'cetak']);
