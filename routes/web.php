<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CekJadwalController;
use App\Http\Controllers\CekPenjemputanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAgentController;
use App\Http\Controllers\DataDestinasiContoller;
use App\Http\Controllers\DataMobilContoller;
use App\Http\Controllers\DataPembayaranContoller;
use App\Http\Controllers\DataPengemudiContoller;
use App\Http\Controllers\DataPenggunaContoller;
use App\Http\Controllers\DataPenjemputanContoller;
use App\Http\Controllers\DataPenumpangContoller;
use App\Http\Controllers\DataPerusahaanController;
use App\Http\Controllers\DataRekeningPerusahaanController;
use App\Http\Controllers\DevRecommendedController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\RatingController;
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
    return redirect(url('/login'));
    // return view('welcome');
});

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'aksiLogin']);

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'aksiRegister']);
});

Route::middleware('auth')->group(function() {
    Route::get('/cf', [DevRecommendedController::class, 'rekomendasi']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Middleware Admin
    // Route::middleware('admin')->group(function() {
        // Data Agent Travel
        Route::get('/data-agent', [DataAgentController::class, 'index'])->name('agent');
        Route::post('/data-agent', [DataAgentController::class, 'tambahAgent'])->name('agent.tambah');
        Route::post('/data-agent/edit', [DataAgentController::class, 'editAgent'])->name('agent.edit');
        Route::get('/data-agent/hapus/{id}', [DataAgentController::class, 'hapusAgent']);

        // Data Pengguna
        Route::get('/data-pengguna', [DataPenggunaContoller::class, 'index'])->name('pengguna');
        Route::post('/data-pengguna/tambah', [DataPenggunaContoller::class, 'tambahPengguna'])->name('pengguna.tambah');
        Route::post('/data-pengguna/edit', [DataPenggunaContoller::class, 'editPengguna'])->name('pengguna.edit');
        Route::get('/data-pengguna/hapus/{id}', [DataPenggunaContoller::class, 'hapusPengguna']);
        Route::get('/data-pengguna/resetpass/{id}', [DataPenggunaContoller::class, 'resetpassPengguna']);

        // Data Pengemudi
        Route::get('/data-pengemudi', [DataPengemudiContoller::class, 'index'])->name('pengemudi');
        Route::post('/data-pengemudi', [DataPengemudiContoller::class, 'tambahPengemudi'])->name('pengemudi.tambah');
        Route::post('/data-pengemudi/edit', [DataPengemudiContoller::class, 'editPengemudi'])->name('pengemudi.edit');
        Route::get('/data-pengemudi/hapus/{id}', [DataPengemudiContoller::class, 'hapusPengemudi']);

        // Data Penumpang
        Route::get('/data-penumpang', [DataPenumpangContoller::class, 'index'])->name('penumpang');
        Route::post('/data-penumpang', [DataPenumpangContoller::class, 'tambahPenumpang'])->name('penumpang.tambah');
        Route::post('/data-penumpang/edit', [DataPenumpangContoller::class, 'editPenumpang'])->name('penumpang.edit');
        Route::get('/data-penumpang/hapus/{id}', [DataPenumpangContoller::class, 'hapusPenumpang']);

        // Data Mobil
        Route::get('/data-mobil', [DataMobilContoller::class, 'index'])->name('mobil');
        Route::post('/data-mobil', [DataMobilContoller::class, 'tambahMobil'])->name('mobil.tambah');
        Route::post('/data-mobil/edit', [DataMobilContoller::class, 'editMobil'])->name('mobil.edit');
        Route::get('/data-mobil/hapus/{id}', [DataMobilContoller::class, 'hapusMobil']);

        Route::get('/data-mobil/cariperusahaan', [DataMobilContoller::class, 'cariPerusahaan'])->name('mobil.perusahaan');

        // Data Perusahaan
        Route::get('/data-perusahaan', [DataPerusahaanController::class, 'index'])->name('perusahaan');
        Route::post('/data-perusahaan', [DataPerusahaanController::class, 'tambahPerusahaan'])->name('perusahaan.tambah');
        Route::post('/data-perusahaan/edit', [DataPerusahaanController::class, 'editPerusahaan'])->name('perusahaan.edit');
        Route::get('/data-perusahaan/hapus/{id}', [DataPerusahaanController::class, 'hapusPerusahaan']);

        // Data Rekening Perusahaan
        Route::get('/data-perusahaan/rekening/{id}', [DataRekeningPerusahaanController::class, 'index'])->name('rekening');
        Route::post('/data-perusahaan/rekening/{id}', [DataRekeningPerusahaanController::class, 'tambahRekening'])->name('rekening.tambah');
        Route::post('/data-perusahaan/rekening/edit/{id}', [DataRekeningPerusahaanController::class, 'editRekening'])->name('rekening.edit');
        Route::get('/data-perusahaan/rekening/hapus/{id}', [DataRekeningPerusahaanController::class, 'hapusRekening']);

        // Data Penjemputan
        Route::get('/data-penjemputan', [DataPenjemputanContoller::class, 'index'])->name('penjemputan');
        Route::post('/data-penjemputan', [DataPenjemputanContoller::class, 'tambahPenjemputan'])->name('penjemputan.tambah');
        Route::post('/data-penjemputan/edit', [DataPenjemputanContoller::class, 'editPenjemputan'])->name('penjemputan.edit');
        Route::get('/data-penjemputan/hapus/{id}', [DataPenjemputanContoller::class, 'hapusPenjemputan']);

        // Atur Data Penjemputan
        Route::get('/data-penjemputan/aturjadwal/{id}', [DataPenjemputanContoller::class, 'penjemputan'])->name('jadwal');
        Route::post('/data-penjemputan/aturjadwal/{id}', [DataPenjemputanContoller::class, 'tambahJadwalJemput'])->name('jadwal.tambah');
        Route::post('/data-penjemputan/aturjadwal/edit/{id}', [DataPenjemputanContoller::class, 'editJadwalJemput'])->name('jadwal.edit');
        Route::get('/data-penjemputan/aturjadwal/hapus/{id}', [DataPenjemputanContoller::class, 'hapusJadwalJemput']);

        // Data Destinasi
        Route::get('/data-destinasi', [DataDestinasiContoller::class, 'index'])->name('destinasi');
        Route::post('/data-destinasi', [DataDestinasiContoller::class, 'tambahDestinasi'])->name('destinasi.tambah');
        Route::post('/data-destinasi/edit', [DataDestinasiContoller::class, 'editDestinasi'])->name('destinasi.edit');
        Route::get('/data-destinasi/hapus/{id}', [DataDestinasiContoller::class, 'hapusDestinasi']);

        // Data Pembayaran
        Route::get('/data-pembayaran', [DataPembayaranContoller::class, 'index'])->name('pembayaran');
        Route::post('/data-pembayaran/konfirmasi', [DataPembayaranContoller::class, 'konfirmasi'])->name('pembayaran.konfirmasi');

        // Data masukan
        Route::get('/data-masukan', [DataMasukanContoller::class, 'index'])->name('masukan');

        // Cek Jadwal
        Route::get('/cek-jadwal', [CekJadwalController::class, 'index'])->name('pengemudi.cekjadwal');

        // Cek Penjemputan
        Route::get('/cek-penjemputan', [CekPenjemputanController::class, 'index'])->name('pengemudi.penjemputan');
        Route::get('/riwayat-penjemputan', [CekPenjemputanController::class, 'riwayatPenjemputan'])->name('pengemudi.riwayatpenjemputan');


        // Pesan Travel
        Route::get('/pesan/kecamatan', [PesananController::class, 'ambilKecamatan'])->name('penumpang.kecamatan');
        Route::get('/pesan/harga-jemput', [PesananController::class, 'ambilHargaJemput'])->name('penumpang.cekharga');
        Route::get('/pesan/waktu-jemput', [PesananController::class, 'waktujemput'])->name('penumpang.waktujemput');

        Route::get('/pesan', [PesananController::class, 'pesan'])->name('penumpang.pesan');
        Route::get('/pesan/cari', [PesananController::class, 'cari'])->name('penumpang.cari');
        Route::get('/pesan/{id}', [PesananController::class, 'pesanTravel'])->name('penumpang.pesanTravel');
        Route::post('/pesan-travel', [PesananController::class, 'pesanTravelPost'])->name('penumpang.pesanTravelPost');

        // Data Pesanan
        Route::get('/data-pesanan', [PesananController::class, 'dataPesanan'])->name('penumpang.pesanan');

        // Upload Bukti Bayar
        Route::post('/buktibayar', [PesananController::class, 'uploadBuktiBayar'])->name('uploadBuktiBayar');

        // Beri Rating
        Route::get('/rating/{id}', [RatingController::class, 'beriRating'])->name('beriRating');
        Route::post('/rating/{id}', [RatingController::class, 'ratingPost'])->name('rating');
        Route::post('/cekrating/{id}', [RatingController::class, 'cekRating']);
    // });
});