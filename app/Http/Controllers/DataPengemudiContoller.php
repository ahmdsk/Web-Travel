<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPengemudiContoller extends Controller
{
    public function index(){
        $data['title']      = 'Data Pengemudi';
        $data['pengemudi']  = DB::table('tbluser')
                        ->join('tbldriver', 'tbldriver.user_id', '=', 'tbluser.id')
                        ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                        ->select('tbluser.*', 'tblperusahaan.*')
                        ->where('role', '=', 'Pengemudi')
                        ->get();
        $data['perusahaan'] = DB::table('tblperusahaan')->get();

        return view('Admin.DataPengemudi.Index', $data);
    }

    public function tambahPengemudi(Request $request){
        $foto = $request->foto;
        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto/'), $fotoBaru);

            $tambahUser = DB::table('tbluser')->insertGetId([
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
                'role'          => 'Pengemudi',
                'password'      => bcrypt('12345678'),
                'foto'          => $fotoBaru
            ]);

            if($tambahUser){
                $tambahPengemudi = DB::table('tbldriver')->insert([
                    'user_id'           => $tambahUser,
                    'perusahaan_id'     => $request->perusahaan
                ]);
    
                if($tambahPengemudi){
                    return back()->with('success', 'Berhasil Menambah Pengemudi!');
                }else{
                    return back()->with('warning', 'Gagal Menambah Pengemudi!');
                }
            }
        }else{
            return back()->with('warning', 'Silahkan Upload Foto!');
        }
    }

    public function editPengemudi(Request $request){
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
                    ]);
        }

        if($updateData){
            $cekAgent = DB::table('tblagent')->where('user_id', $request->id_user)->first();
            if($cekAgent){
                DB::table('tblagent')->where('id_agent', $cekAgent->id_agent)->update([
                    'perusahaan_id' => $request->perusahaan
                ]);
            }

            return back()->with('success', 'Berhasil Update Data!');
        }else{
            return back()->with('warning', 'Gagal Update Data!');
        }
    }

    public function hapusPengemudi($id){
        $user = DB::table('tbluser')->where('id', $id)->first();

        $cariAgent = DB::table('tbldriver')->where('user_id', $user->id)->first();
        if($cariAgent != null){
            // hapus agent
            DB::table('tbldriver')->where('user_id', $user->id)->delete();
        }

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
