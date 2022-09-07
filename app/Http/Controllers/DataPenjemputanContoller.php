<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPenjemputanContoller extends Controller
{
    public function index(){
        $data['title']       = 'Data Penjemputan';
        $data['penjemputan'] = DB::table('tblpenjemputan')->orderBy('id', 'desc')->get();
        
        return view('Admin.DataPenjemputan.Index', $data);
    }

    public function tambahPenjemputan(Request $request){
        $tambaPenjemputan = DB::table('tblpenjemputan')->insert([
            'nama_kota'         => ucwords($request->nama_kota),
            'kecamatan'         => ucwords($request->kecamatan),
            'harga'             => $request->harga,
        ]);

        if($tambaPenjemputan){
            return back()->with('success', 'Berhasil Menambah Data Penjemputan!');
        }else{
            return back()->with('warning', 'Gagal Menambah Data Penjemputan!');
        }
    }

    public function editPenjemputan(Request $request){
        $ubahPenjemputan = DB::table('tblpenjemputan')
            ->where('id', $request->id_penjemputan)
            ->update([
                'nama_kota'         => ucwords($request->nama_kota),
                'kecamatan'         => ucwords($request->kecamatan),
                'harga'             => $request->harga,
            ]);

        if($ubahPenjemputan){
            return back()->with('success', 'Berhasil Ubah Data Penjemputan!');
        }else{
            return back()->with('warning', 'Gagal Ubah Data Penjemputan!');
        }
    }

    public function hapusPenjemputan($id){
        $hapusPenjemputan = DB::table('tblpenjemputan')->where('id', $id)->delete();

        if($hapusPenjemputan){
            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 500
            ]);
        }
    }


    // Atur Jadwal Penjemputan
    public function penjemputan($id){
        $data['jadwal']      = DB::table('tblpenjemputan')->where('id', $id)->first();
        $data['title']       = 'Jadwal Penjemputan';
        $data['penjemputan'] = DB::table('tblwaktu_penjemputan')->where('id_penjemputan', $id)->get();
        
        return view('Admin.DataPenjemputan.JadwalJemput', $data);
    }

    public function tambahJadwalJemput(Request $request, $id)
    {
        $tambahJadwalJemput = DB::table('tblwaktu_penjemputan')
            ->insert([
                'id_penjemputan'    => $id,
                'waktu_penjemputan' => $request->waktu_penjemputan,
            ]);

        if ($tambahJadwalJemput) {
            return back()->with('success', 'Berhasil Tambah Jadwal Jemput!');
        } else {
            return back()->with('success', 'Gagal Tambah Jadwal Jemput!');
        }
    }

    public function editJadwalJemput(Request $request, $id)
    {
        $ubahJadwalJemput = DB::table('tblwaktu_penjemputan')
            ->where('id', $id)
            ->update([
                'waktu_penjemputan' => $request->waktu_penjemputan,
            ]);

        if ($ubahJadwalJemput) {
            return back()->with('success', 'Berhasil Jadwal Jemput!');
        } else {
            return back()->with('warning', 'Gagal Jadwal Jemput!');
        }
    }

    public function hapusJadwalJemput($id){
        $hapusJadwalJemput = DB::table('tblwaktu_penjemputan')->where('id', $id)->delete();

        if($hapusJadwalJemput){
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