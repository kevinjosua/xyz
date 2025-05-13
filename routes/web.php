<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\KurirController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/rekap-data-pengiriman', [InputDataController::class, 'index'])->name('rekap.data');
Route::get('/input-data-pengiriman', [InputDataController::class, 'create'])->name('input.data');
Route::post('/simpan-data-pengiriman', [InputDataController::class, 'store'])->name('store.data');

Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman');
Route::get('/kurir', [KurirController::class, 'index'])->name('kurir');
Route::get('/kurir/tambah-kurir', [KurirController::class, 'create'])->name('kurir.create');
Route::get('/kurir/edit/{id}', [KurirController::class, 'edit'])->name('kurir.edit');
Route::put('/kurir/{id}', [KurirController::class, 'update'])->name('kurir.update');
Route::post('/kurir/simpan-kurir', [KurirController::class, 'store'])->name('kurir.store');
Route::delete('/kurir/delete/{id}', [KurirController::class, 'delete'])->name('kurir.delete');


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authenticate');