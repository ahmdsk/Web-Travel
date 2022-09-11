<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataDestinasiContoller extends Controller
{
    public function index(){
        $data['title']       = 'Data Destinasi';
        
        if(Auth::user()->role == 'Agent'){
            $cekPerusahaan = DB::table('tblperusahaan')
                        ->join('tblagent', 'tblagent.perusahaan_id', '=', 'tblperusahaan.id_perusahaan')
                        ->where('user_id', Auth::user()->id)->first();

            $data['destinasi']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->select('destinasi.*', 'tblmobil.*', 'tbldriver.*', 'tbluser.nama')
                    ->where('tbldriver.perusahaan_id', $cekPerusahaan->id_perusahaan)
                    ->get();

            $data['mobil']  = DB::table('tblmobil')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->where('tbldriver.perusahaan_id', $cekPerusahaan->id_perusahaan)
                    ->get();
        }else{
            $data['destinasi']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->select('destinasi.*', 'tblmobil.*', 'tbldriver.*', 'tbluser.nama')
                    ->get();

            $data['mobil']  = DB::table('tblmobil')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->get();
        }

        return view('Admin.DataDestinasi.Index', $data);
    }

    public function tambahDestinasi(Request $request)
    {
        $tambahDestinasi = DB::table('destinasi')
            ->insert([
                'mobil_id'          => $request->id_mobil,
                'nama_destinasi'    => ucwords($request->nama_destinasi),
                'harga_destinasi'   => ucwords($request->harga_destinasi),
            ]);

        if ($tambahDestinasi) {
            return back()->with('success', 'Berhasil Tambah Destinasi!');
        } else {
            return back()->with('success', 'Gagal Tambah Destinasi!');
        }
    }

    public function editDestinasi(Request $request)
    {
        $ubahDestinasi = DB::table('destinasi')
            ->where('id', $request->id_destinasi)
            ->update([
                'mobil_id'          => $request->id_mobil,
                'nama_destinasi'    => ucwords($request->nama_destinasi),
                'harga_destinasi'   => ucwords($request->harga_destinasi),
            ]);

        if ($ubahDestinasi) {
            return back()->with('success', 'Berhasil Update Destinasi!');
        } else {
            return back()->with('warning', 'Gagal Update Destinasi!');
        }
    }

    public function hapusDestinasi($id){
        $hapusDestinasi = DB::table('destinasi')->where('id', $id)->delete();

        if($hapusDestinasi){
            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 500
            ]);
        }
    }
}
