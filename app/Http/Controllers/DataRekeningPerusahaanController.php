<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataRekeningPerusahaanController extends Controller
{
    public function index($id)
    {
        $data['perusahaan'] = DB::table('tblperusahaan')->where('id_perusahaan', $id)->first();
        $data['title']      = 'Atur Pembayaran Perusahaan: ' . $data['perusahaan']->nama_perusahaan;
        $data['rekening']   = DB::table('tblpembayaran_perusahaan')->where('perusahaan_id', $id)->get();

        return view('Admin.DataRekening.Index', $data);
    }

    public function tambahRekening(Request $request, $id)
    {
        $tambahRekening = DB::table('tblpembayaran_perusahaan')
            ->insert([
                'perusahaan_id' => $id,
                'nama_pemilik'  => $request->pimpinan,
                'no_rekening'   => $request->no_rek,
                'nama_bank'     => $request->nama_bank
            ]);

        if ($tambahRekening) {
            return back()->with('success', 'Berhasil Tambah Rekening!');
        } else {
            return back()->with('success', 'Gagal Tambah Rekening!');
        }
    }

    public function editRekening(Request $request, $id)
    {
        $ubahRekening = DB::table('tblpembayaran_perusahaan')
            ->where('id', $id)
            ->update([
                'nama_pemilik'  => $request->pimpinan,
                'no_rekening'   => $request->no_rek,
                'nama_bank'     => $request->nama_bank
            ]);

        if ($ubahRekening) {
            return back()->with('success', 'Berhasil Update Rekening!');
        } else {
            return back()->with('warning', 'Gagal Update Rekening!');
        }
    }

    public function hapusRekening($id){
        $hapusRekening = DB::table('tblpembayaran_perusahaan')->where('id', $id)->delete();

        if($hapusRekening){
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
