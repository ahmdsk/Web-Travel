<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPenumpangContoller extends Controller
{
    public function index(){
        $data['title']      = 'Data Penumpang';
        $data['penumpang']  = DB::table('tbluser')->where('role', 'Penumpang')->get();

        return view('Admin.DataPenumpang.Index', $data);
    }

    public function tambahPenumpang(Request $request){
        // cek jika ada foto
        $foto= $request->foto;
        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto/'), $fotoBaru);
            
            $tambahDataUser = DB::table('tbluser')->insert([
                'username'      => $request->username,
                'nama'          => $request->nama_lengkap,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'role'          => 'Penumpang',
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'url_alamat'    => $request->link_alamat,
                'foto'          => $fotoBaru,
            ]);
        }else{
            $tambahDataUser = DB::table('tbluser')->insert([
                'username'      => $request->username,
                'nama'          => $request->nama_lengkap,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'role'          => 'Penumpang',
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'url_alamat'    => $request->link_alamat,
            ]);
        }

        if($tambahDataUser){
            return back()->with('success', 'Berhasil Menambah Penumpang!');
        }else{
            return back()->with('warning', 'Gagal Menambah Penumpang!');
        }
    }

    public function editPenumpang(Request $request){
        // cek apakah ada foto atau tidak
        $foto = $request->foto;

        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto/'), $fotoBaru);

            $updateData = DB::table('tbluser')
                    ->where('id', $request->id_user)
                    ->update([
                        'username'      => $request->username,
                        'nama'          => $request->nama_lengkap,
                        'email'         => $request->email,
                        'no_telp'       => $request->no_telp,
                        'nik'           => $request->nik,
                        'tgl_lahir'     => $request->tgl_lahir,
                        'umur'          => $request->umur,
                        'agama'         => $request->agama,
                        'alamat'        => $request->alamat,
                        'url_alamat'    => $request->link_alamat,
                        'role'          => 'Penumpang',
                        'foto'          => $fotoBaru
                    ]);
        }else{
            $updateData = DB::table('tbluser')
                    ->where('id', $request->id_user)
                    ->update([
                        'username'      => $request->username,
                        'nama'          => $request->nama_lengkap,
                        'email'         => $request->email,
                        'no_telp'       => $request->no_telp,
                        'nik'           => $request->nik,
                        'tgl_lahir'     => $request->tgl_lahir,
                        'umur'          => $request->umur,
                        'agama'         => $request->agama,
                        'alamat'        => $request->alamat,
                        'url_alamat'    => $request->link_alamat,
                        'role'          => 'Penumpang',
                    ]);
        }

        if($updateData){
            return back()->with('success', 'Berhasil Update Data!');
        }else{
            return back()->with('warning', 'Gagal Update Data!');
        }
    }
    
    public function hapusPenumpang($id){
        $hapusUser = DB::table('tbluser')->where('id', $id)->delete();

        if($hapusUser){
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
