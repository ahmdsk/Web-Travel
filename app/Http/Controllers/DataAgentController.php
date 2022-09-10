<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataAgentController extends Controller
{
    public function index(){
        $data['title']  = 'Data Agent Travel';
        $data['agent']  = DB::table('tbluser')
                        ->join('tblagent', 'tblagent.user_id', '=', 'tbluser.id')
                        ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblagent.perusahaan_id')
                        ->select('tbluser.*', 'tblperusahaan.*', 'tblagent.id_agent')
                        ->where('role', '=', 'Agent')
                        ->get();
        $data['perusahaan'] = DB::table('tblperusahaan')->get();

        return view('Admin.DataAgent.Index', $data);
    }

    public function tambahAgent(Request $request){
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
                'role'          => 'Agent',
                'password'      => bcrypt('12345678'),
                'status_aktif'  => 1,
                'foto'          => $fotoBaru
            ]);
        }else{
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
                'role'          => 'Agent',
                'password'      => bcrypt('12345678'),
                'status_aktif'  => 1,
            ]);
        }

        if($tambahUser){
            $tambahAgent = DB::table('tblagent')->insert([
                'user_id'           => $tambahUser,
                'perusahaan_id'     => $request->perusahaan
            ]);

            if($tambahAgent){
                return back()->with('success', 'Berhasil Menambah Agent Travel!');
            }else{
                return back()->with('warning', 'Gagal Menambah Agent Travel!');
            }
        }
    }

    public function editAgent(Request $request){
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
                    ]);
        }

        if($updateData){
            $cekDriver = DB::table('tbldriver')->where('user_id', $request->id_user)->first();
            if($cekDriver){
                DB::table('tbldriver')->where('id_driver', $cekDriver->id_driver)->update([
                    'perusahaan_id' => $request->perusahaan
                ]);
            }

            return back()->with('success', 'Berhasil Update Data!');
        }else{
            return back()->with('warning', 'Gagal Update Data!');
        }
    }

    public function hapusAgent($id){
        $user = DB::table('tbluser')->where('id', $id)->first();

        $cariAgent = DB::table('tblagent')->where('user_id', $user->id)->first();
        if($cariAgent != null){
            // hapus agent
            DB::table('tblagent')->where('user_id', $user->id)->delete();
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