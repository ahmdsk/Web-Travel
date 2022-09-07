<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function pesan(){
        $data['title']       = 'Pesan Travel';
        $data['ibukota']     = DB::table('tblpenjemputan')->distinct('nama_kota')->pluck('nama_kota');
        $data['kecamatan']   = DB::table('tblpenjemputan')->distinct('kecamatan')->pluck('kecamatan');
        $data['listMobil']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                    ->orderBy('destinasi.id', 'desc')
                    ->get();

        return view('Penumpang.PesanTravel.Index', $data);
    }

    public function cari(Request $request){
        $data['listMobil']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                    ->where('nama_destinasi', 'like', '%'.$request->destinasi.'%')
                    ->orderBy('destinasi.id', 'desc')
                    ->get();

        return view('Penumpang.PesanTravel._DataTravelJson', $data);
    }

    public function pesanTravel($id){
        $data['title']  = 'Pesan Travel';
        $data['ibukota']     = DB::table('tblpenjemputan')->distinct('nama_kota')->pluck('nama_kota');
        $data['kecamatan']   = DB::table('tblpenjemputan')->distinct('kecamatan')->pluck('kecamatan');
        $data['mobil']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                    ->where('destinasi.id', $id)
                    ->orderBy('destinasi.id', 'desc')
                    ->first();

        $data['rekening'] = DB::table('tblpembayaran_perusahaan')->where('perusahaan_id', $data['mobil']->perusahaan_id)->get();

        return view('Penumpang.PesanTravel.Pesan', $data);
    }
}