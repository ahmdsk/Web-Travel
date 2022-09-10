<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CekPenjemputanController extends Controller
{
    public function index(){
        $data['title']  = 'Cek Penjemputan';
        $data['pemesanan']  = DB::table('tblpemesanan')
                    ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                    ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
                    ->where('tbldriver.user_id', Auth::user()->id)
                    ->where('status_bayar', 'Terkonfirmasi')
                    ->select('tblpemesanan.*', 'destinasi.*', 'tblmobil.*', 'tbluser.nama', 'tblpenjemputan.*')
                    ->get();

        return view('Pengemudi.DataJemput.Index', $data);
    }

    public function riwayatPenjemputan(){
        $data['title']  = 'Riwayat Penjemputan';
        $data['riwayat']  = DB::table('tblpemesanan')
                    ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                    ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
                    ->where('tbldriver.user_id', Auth::user()->id)
                    ->select('tblpemesanan.*', 'destinasi.*', 'tblmobil.*', 'tbluser.nama', 'tblpenjemputan.*')
                    ->where('status_bayar', 'Selesai')
                    ->get();

        return view('Pengemudi.DataJemput.RiwayatPenjemputan', $data);
    }
}
