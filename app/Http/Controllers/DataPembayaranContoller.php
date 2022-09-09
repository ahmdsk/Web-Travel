<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPembayaranContoller extends Controller
{
    public function index(){
        $data['title']  = 'Konfirmasi Pembayaran';
        $data['pemesanan']  = DB::table('tblpemesanan')
            ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
            ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
            ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
            ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
            ->orderBy('id_pesanan', 'desc')->get();

        return view('Admin.Pembayaran.Index', $data);
    }

    public function konfirmasi(Request $request){
        $konfirmasi = DB::table('tblpemesanan')
                ->where('id_pesanan', $request->id_pesanan)
                ->update([
                    'status_bayar' => $request->status_bayar
                ]);

        if($konfirmasi){
            if(Auth::user()->role == 'Pengemudi'){
                $pesan = 'Berhasil Konfirmasi Antar Penumpang!';
            }else{
                $pesan = 'Berhasil Update Status Pesanan!';
            }

            return back()->with('success', $pesan);
        }else{
            return back()->with('warning', 'Gagal Update Status Pesanan!');
        }
    }
}