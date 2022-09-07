<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPerusahaanController extends Controller
{
    public function index(){
        $data['title']       = 'Data Perusahaan';
        $data['perusahaan']  = DB::table('tblperusahaan')->get();

        return view('Admin.DataPerusahaan.Index', $data);
    }

    public function tambahPerusahaan(Request $request){
        $tambahPerusahaan = DB::table('tblperusahaan')->insert([
            'nama_perusahaan'       => $request->nama_perusahaan,
            'pimpinan_perusahaan'   => $request->pimpinan,
            'no_telpon_perusahaan'  => $request->no_telp,
            'alamat_perusahaan'     => $request->alamat,
        ]);

        if($tambahPerusahaan){
            return back()->with('success', 'Berhasil Menambah Perusahaan');
        }else{
            return back()->with('warning', 'Gagal Menambah Perusahaan');
        }
    }

    public function editPerusahaan(Request $request){
        $ubahPerusahaan = DB::table('tblperusahaan')->where('id_perusahaan', $request->id_perusahaan)
                    ->update([
                        'nama_perusahaan'       => $request->nama_perusahaan,
                        'pimpinan_perusahaan'   => $request->pimpinan,
                        'no_telpon_perusahaan'  => $request->no_telp,
                        'alamat_perusahaan'     => $request->alamat,
                    ]);

        if($ubahPerusahaan){
            return back()->with('success', 'Berhasil Ubah Perusahaan!');
        }else{
            return back()->with('warning', 'Gagal Ubah Perusahaan!');
        }
    }

    public function hapusPerusahaan($id){
        $hapusPerusahaan = DB::table('tblperusahaan')->where('id_perusahaan', $id)->delete();

        if($hapusPerusahaan){
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
