<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard';

        if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Agent'){

            $data['jumlahPendapatan'] = DB::table('tblpemesanan')
                    ->where('status_bayar', 'Terkonfirmasi')
                    ->sum('total_harga');

            $data['jumlahAgent']     = DB::table('tbluser')->where('role', 'Agent')->count();
            $data['jumlahPengemudi'] = DB::table('tbluser')->where('role', 'Pengemudi')->count();
            $data['jumlahPenumpang'] = DB::table('tbluser')->where('role', 'Penumpang')->count();

        }elseif(Auth::user()->role == 'Pengemudi'){

            $data['jumlahJadwal'] = DB::table('tblpemesanan')
                ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
                ->where('tbldriver.user_id', Auth::user()->id)
                ->where('status_bayar', 'Terkonfirmasi')
                ->count();

        }elseif(Auth::user()->role == 'Penumpang'){

            $data['jumlahPesanan'] = DB::table('tblpemesanan')
                ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                ->where('user_id', Auth::user()->id)
                ->whereNotIn('status_bayar', ['Selesai'])
                ->count();

        }

        return view('Dashboard', $data);
    }
}
