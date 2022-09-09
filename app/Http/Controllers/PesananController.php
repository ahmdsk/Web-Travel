<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    function ambilKecamatan(Request $request){
        $kecamatan  = DB::table('tblpenjemputan')->where('nama_kota', $request->kota)->distinct('kecamatan')->pluck('kecamatan');
        return response()->json([
            'status' => 200,
            'data'   => $kecamatan
        ]);
    }

    function ambilHargaJemput(Request $request){
        $cekHargaJemput = DB::table('tblpenjemputan')->where('kecamatan', $request->kecamatan)->first();
        return response()->json([
            'status' => 200,
            'data'   => $cekHargaJemput
        ]);
    }

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

    public function dataPesanan(){
        $data['title'] = 'Data Pesanan';
        $data['pesanan']  = DB::table('tblpemesanan')
                ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                ->leftjoin('tblrating', 'tblrating.id_pesanan', '=', 'tblpemesanan.id_pesanan')
                ->select('tblpemesanan.*', 'destinasi.*', 'tblpenjemputan.*', 'tbluser.*', 'tblmobil.*', 'tblrating.rating')
                ->where('user_id', Auth::user()->id)
                ->get();

        return view('Penumpang.DataPesanan.Index', $data);
    }

    public function pesanTravel($id){
        $data['title']  = 'Pesan Travel';
        $data['ibukota']     = DB::table('tblpenjemputan')->distinct('nama_kota')->pluck('nama_kota');
        $data['mobil']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                    ->where('destinasi.id', $id)
                    ->orderBy('destinasi.id', 'desc')
                    ->first();

        $data['cekKursi'] = DB::table('tblpemesanan')->where('mobil_id', $id)->get();
                    
        $data['rekening'] = DB::table('tblpembayaran_perusahaan')->where('perusahaan_id', $data['mobil']->perusahaan_id)->get();

        return view('Penumpang.PesanTravel.Pesan', $data);
    }

    public function pesanTravelPost(Request $request){
        $file_bukti = $request->bukti_bayar;
        $file_bukti_baru = rand().'.'.$file_bukti->getClientOriginalExtension();
        $file_bukti->move(public_path('bukti_bayar/'), $file_bukti_baru);

        // cek apakah kursi kosong
        $cekKursi = DB::table('tblpemesanan')
                ->where('mobil_id', $request->id_mobil)
                ->where('no_kursi', $request->no_kursi)
                ->get();

        if(count($cekKursi) < 1){
            $tambahPesanan = DB::table('tblpemesanan')->insert([
                'total_harga'           => $request->total_bayar,
                'status_bayar'          => 'Pending',
                'tgl_perjalanan'        => date('Y-m-d'),
                'detail_penjemputan'    => $request->alamat,
                'destinasi_id'          => $request->destinasi_id,
                'penjemputan_id'        => $request->penjemputan_id,
                'mobil_id'              => $request->id_mobil,
                'no_kursi'              => $request->no_kursi,
                'user_id'               => Auth::user()->id,
                'url_alamat'            => $request->url_alamat,
                'bukti_bayar'           => $file_bukti_baru
            ]);

            if($tambahPesanan){
                return redirect(route('penumpang.pesanan'))->with('success', 'Berhasil Menambah Pesanan!');
            }else{
                return back()->with('warning', 'Gagal Menambah Pesanan!');
            }
        }else{
            return back()->with('warning', 'Maaf Kursi Telah Terisi!');
        }
    }
}