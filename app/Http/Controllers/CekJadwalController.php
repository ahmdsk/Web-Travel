<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CekJadwalController extends Controller
{
    public function index(){
        $data['title']  = 'Cek Jadwal';
        $data['pemesanan']  = DB::table('tblpemesanan')
                    ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                    ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
                    ->where('tbldriver.user_id', Auth::user()->id)
                    ->where('status_bayar', 'Terkonfirmasi')
                    ->get();

        return view('Pengemudi.DataJadwal.Index', $data);
    }
}
