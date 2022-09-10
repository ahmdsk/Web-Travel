<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataMobilContoller extends Controller
{
    public function index(){
        $data['title']  = 'Data Mobil Travel';
        $data['mobil']  = DB::table('tblmobil')
                        ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                        ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                        ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                        ->get();

        $data['driver'] = DB::table('tbldriver')
                        ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                        ->where('status_aktif', 1)->get();

        $data['perusahaan'] = DB::table('tblperusahaan')->get();

        return view('Admin.DataMobilTravel.Index', $data);
    }

    public function tambahMobil(Request $request){
        $foto = $request->foto;
        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto_mobil/'), $fotoBaru);

            $tambahMobil = DB::table('tblmobil')->insert([
                'perusahaan_id'     => $request->id_perusahaan,
                'driver_id'         => $request->id_pengemudi,
                'no_polisi'         => $request->no_polisi,
                'merk_mobil'        => $request->merk_mobil,
                'warna_mobil'       => $request->warna,
                'jumlah_kursi'      => $request->kapasitas,
                'fasilitas'         => $request->fasilitas,
                'foto_mobil'        => $fotoBaru
            ]);

            if($tambahMobil){
                return back()->with('success', 'Berhasil Menambah Mobil Travel!');
            }else{
                return back()->with('warning', 'Gagal Menambah Mobil Travel!');
            }
        }else{
            return back()->with('warning', 'Silahkan Upload Foto Mobil!');
        }
    }

    public function editMobil(Request $request){
        // cek apakah ada foto atau tidak
        $foto = $request->foto;

        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto_mobil/'), $fotoBaru);

            $updateMobil = DB::table('tblmobil')
                    ->where('id_mobil', $request->id_mobil)
                    ->update([
                        'perusahaan_id'     => $request->id_perusahaan,
                        'driver_id'         => $request->id_pengemudi,
                        'no_polisi'         => $request->no_polisi,
                        'merk_mobil'        => $request->merk_mobil,
                        'warna_mobil'       => $request->warna,
                        'jumlah_kursi'      => $request->kapasitas,
                        'fasilitas'         => $request->fasilitas,
                        'foto_mobil'        => $fotoBaru
                    ]);
        }else{
            $updateMobil = DB::table('tblmobil')
                    ->where('id_mobil', $request->id_mobil)
                    ->update([
                        'perusahaan_id'     => $request->id_perusahaan,
                        'driver_id'         => $request->id_pengemudi,
                        'no_polisi'         => $request->no_polisi,
                        'merk_mobil'        => $request->merk_mobil,
                        'warna_mobil'       => $request->warna,
                        'jumlah_kursi'      => $request->kapasitas,
                        'fasilitas'         => $request->fasilitas,
                    ]);
        }

        if($updateMobil){
            return back()->with('success', 'Berhasil Update Data Mobil Travel!');
        }else{
            return back()->with('warning', 'Gagal Update Data Mobil Travel!');
        }
    }

    public function hapusMobil($id){
        $hapusMobil = DB::table('tblmobil')->where('id_mobil', $id)->delete();

        if($hapusMobil){
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
