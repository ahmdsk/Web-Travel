<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['title'] = 'Dashboard';

        if(Auth::user()->role == 'Admin'){

            $data['jumlahPendapatan'] = DB::table('tblpemesanan')
                    ->where('status_bayar', 'Selesai')
                    ->sum('total_harga');

            $data['jumlahAgent']     = DB::table('tbluser')->where('role', 'Agent')->count();
            $data['jumlahPengemudi'] = DB::table('tbluser')->where('role', 'Pengemudi')->count();
            $data['jumlahPenumpang'] = DB::table('tbluser')->where('role', 'Penumpang')->count();

        }elseif(Auth::user()->role == 'Agent'){

            $cekPerusahaanAgent = DB::table('tbluser')
                            ->join('tblagent', 'tblagent.user_id', '=', 'tbluser.id')
                            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblagent.perusahaan_id')
                            ->where('id', Auth::user()->id)->first();

            $data['jumlahPendapatan'] = DB::table('tblpemesanan')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                    ->where('perusahaan_id', $cekPerusahaanAgent->id_perusahaan)
                    ->where('status_bayar', 'Selesai')
                    ->sum('total_harga');

            $data['jumlahAgent']     = DB::table('tbluser')
                            ->join('tblagent', 'tblagent.user_id', '=', 'tbluser.id')
                            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblagent.perusahaan_id')
                            ->select('tbluser.*', 'tblperusahaan.*')
                            ->where('id_perusahaan', $cekPerusahaanAgent->id_perusahaan)
                            ->where('role', '=', 'Agent')
                            ->count();

            $data['jumlahPengemudi'] = DB::table('tbluser')
                            ->join('tbldriver', 'tbldriver.user_id', '=', 'tbluser.id')
                            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                            ->select('tbluser.*', 'tblperusahaan.*')
                            ->where('id_perusahaan', $cekPerusahaanAgent->id_perusahaan)
                            ->where('role', '=', 'Pengemudi')
                            ->count();
            
            $data['jumlahPenumpang'] = DB::table('tbluser')->where('role', '=', 'Penumpang')->count();

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
