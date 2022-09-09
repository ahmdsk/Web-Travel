<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function beriRating($id){
        $data['title'] = 'Beri Rating Pesanan';
        $data['pesanan'] = DB::table('tblpemesanan')
                ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
                ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
                ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
                ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
                ->where('id_pesanan', $id)->first();

        return view('Penumpang.DataPesanan.Rating', $data);
    }

    public function ratingPost(Request $request, $id){
        $beriRating = DB::table('tblrating')->insert([
            'rating'        => $request->rating,
            'keterangan'    => $request->keterangan,
            'id_pesanan'    => $id,
            'id_user'       => Auth::user()->id
        ]);

        if($beriRating){
            return back()->with('success', 'Terimakasih Telah Memberi Rating');
        }else{
            return back()->with('warning', 'Gagal Member Rating');
        }
    }
}
