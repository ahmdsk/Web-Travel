<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('Auth.login');
    }

    public function aksiLogin(Request $request){
        $validasi = $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        if($validasi){
            $auth = Auth::attempt($validasi);

            if($auth){
                return redirect(route('dashboard'))->with('success', 'Berhasil Login');
            }else{
                return back()->with('warning', 'Username / Password Salah!');
            }
        }
    }

    public function register(){
        $data['perusahaan'] = DB::table('tblperusahaan')->get();

        return view('Auth.register', $data);
    }

    public function aksiRegister(Request $request){
        // dd($request->all());

        $hak_akses = $request->akses;

        if($hak_akses == null){
            return back()->with('error', 'Silahkan Pilih Role Untuk Mendaftar!');
        }

        // cek role
        if($request->akses == 'Penumpang'){
            $validasi = $request->validate([
                "username"      => 'required|unique:tbluser',
                "nama_lengkap"  => 'required',
                "email"         => 'required|unique:tbluser',
                "password"      => 'required|min:3',
                "no_telp"       => 'required',
                "tgl_lahir"     => 'required',
                "nik"           => 'required',
                "alamat"        => 'required',
            ]);
        }elseif($request->akses == 'Pengemudi'){
            $validasi = $request->validate([
                "username"      => 'required|unique:tbluser',
                "nama_lengkap"  => 'required',
                "email"         => 'required|unique:tbluser',
                "password"      => 'required|min:3',
                "no_telp"       => 'required',
                "tgl_lahir"     => 'required',
                "nik"           => 'required',
                "umur"          => 'required',
                "agama"         => 'required',
                "alamat"        => 'required',
                "perusahaan"    => 'required',
                "foto"          => 'required',
            ]);
        }elseif($request->akses == 'Agent'){
            $validasi = $request->validate([
                "username"      => 'required|unique:tbluser',
                "nama_lengkap"  => 'required',
                "email"         => 'required|unique:tbluser',
                "password"      => 'required|min:3',
                "no_telp"       => 'required',
                "nik"           => 'required',
                "perusahaan"    => 'required',
            ]);
        }

        // cek jika data telah lengkap
        if($validasi){
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
                        Auth::loginUsingId($tambahDataUser);
                        return redirect(route('dashboard'))->with('success', 'Berhasil Login!');
                    }else{
                        return back()->with('warning', 'Gagal Mendaftar!');
                    }
                }elseif($hak_akses == 'Agent'){
                    // tambah Agent
                    $tambahAgent = DB::table('tblagent')->insert([
                        'user_id'       => $tambahDataUser,
                        'perusahaan_id' => $request->perusahaan
                    ]);

                    if($tambahAgent){
                        Auth::loginUsingId($tambahDataUser);
                        return redirect(route('dashboard'))->with('success', 'Berhasil Login!');
                    }else{
                        return back()->with('warning', 'Gagal Mendaftar!');
                    }
                }else{
                    Auth::loginUsingId($tambahDataUser);
                    return redirect(route('dashboard'))->with('success', 'Berhasil Login!');
                }
            }else{
                return back()->with('warning', 'Gagal Mendaftar!');
            }
        }else{
            return back()->with('warning', 'Maaf Data Anda Sebagai '.$hak_akses.' Belum Lengkap!');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(route('login'))->with('success', 'Berhasil Logout!');
    }
}
