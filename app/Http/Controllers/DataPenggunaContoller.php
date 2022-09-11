<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPenggunaContoller extends Controller
{
    public function index(){
        $data['title']      = 'Data Pengguna';
        $data['pengguna']   = DB::table('tbluser')->get();
        $data['perusahaan'] = DB::table('tblperusahaan')->get();

        return view('Admin.DataPengguna.Index', $data);
    }

    public function tambahPengguna(Request $request){
        // dd($request->all());

        $hak_akses = $request->akses;

        if($hak_akses == null){
            return back()->with('error', 'Silahkan Pilih Role Akses!');
        }

        $cekUserName = DB::table('tbluser')->where('username', $request->username)->count();

        if($cekUserName > 0){
            return back()->with('warning', 'Maaf Username '.$request->username.' Telah Digunakan!');
        }

        // cek jika ada foto
        $foto= $request->foto;
        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto/'), $fotoBaru);
            
            $tambahDataUser = DB::table('tbluser')->insertGetId([
                'username'      => $request->username,
                'nama'          => $request->nama_lengkap,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'role'          => $hak_akses,
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'url_alamat'    => $request->link_alamat,
                'status_aktif'  => 1,
                'foto'          => $fotoBaru,
            ]);
        }else{
            $tambahDataUser = DB::table('tbluser')->insertGetId([
                'username'      => $request->username,
                'nama'          => $request->nama_lengkap,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'role'          => $hak_akses,
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'url_alamat'    => $request->link_alamat,
                'status_aktif'  => 1,
            ]);
        }

        if($tambahDataUser){
            if($hak_akses == 'Pengemudi'){
                // tambah Pengemudi
                $tambahPengemudi = DB::table('tbldriver')->insert([
                    'user_id'       => $tambahDataUser,
                    'perusahaan_id' => $request->perusahaan
                ]);

                if($tambahPengemudi){
                    return back()->with('success', 'Berhasil Menambah Pengemudi!');
                }else{
                    return back()->with('warning', 'Gagal Menambah Pengemudi!');
                }
            }elseif($hak_akses == 'Agent'){
                // tambah Agent
                $tambahAgent = DB::table('tblagent')->insert([
                    'user_id'       => $tambahDataUser,
                    'perusahaan_id' => $request->perusahaan
                ]);

                if($tambahAgent){
                    return back()->with('success', 'Berhasil Menambah Agent Travel!');
                }else{
                    return back()->with('warning', 'Gagal Menambah Agent Travel!');
                }
            }else{
                return back()->with('success', 'Berhasil Menambah Pengguna!');
            }
        }else{
            return back()->with('warning', 'Gagal Menambah Pengguna!');
        }
    }

    public function hapusPengguna($id){
        $user = DB::table('tbluser')->where('id', $id)->first();
        
        // if($user->role == 'Pengemudi'){
        //     $cariPengemudi = DB::table('tbldriver')->where('user_id', $user->id)->first();
        //     if($cariPengemudi != null){
        //         // hapus pengemudi
        //         $hapusUser = DB::table('tbldriver')->where('user_id', $user->id)->delete();
        //     }
        // }elseif($user->role == 'Agent'){
        //     $cariAgent = DB::table('tblagent')->where('user_id', $user->id)->first();
        //     if($cariAgent != null){
        //         // hapus agent
        //         $hapusUser = DB::table('tblagent')->where('user_id', $user->id)->delete();
        //     }
        // }

        if($user->status_aktif == 1){
            $hapusUser = DB::table('tbluser')->where('id', $id)->update([
                'status_aktif' => 0
            ]);
        }else{
            $hapusUser = DB::table('tbluser')->where('id', $id)->update([
                'status_aktif' => 1
            ]);
        }

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

    public function resetpassPengguna($id){
        $resetPassUser = DB::table('tbluser')
                ->where('id', $id)->update([
                    'password' => bcrypt('12345678')
                ]);

        if($resetPassUser){
            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 500
            ]);
        }
    }

    public function editPengguna(Request $request){
        // dd($request);
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
                        'role'          => $request->akses,
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
                        'role'          => $request->akses,
                    ]);
        }

        if($updateData){
            return back()->with('success', 'Berhasil Update Data!');
        }else{
            return back()->with('warning', 'Gagal Update Data!');
        }
    }
}
