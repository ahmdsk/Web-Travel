<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $cekuser = DB::table('tbluser')
            ->where('username', $request->username)
            ->first();

        if($cekuser->status_aktif == 1){
            if($validasi){
                $auth = Auth::attempt($validasi);
    
                if($auth){
                    return redirect(route('dashboard'))->with('success', 'Berhasil Login');
                }else{
                    return back()->with('warning', 'Username / Password Salah!');
                }
            }
        }else{
            return back()->with('warning', 'Maaf Pengguna Atas Nama '.$cekuser->nama.' Telah Di Non-Aktifkan!');
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

    public function ubahProfile(){
        $data['title']      = 'Ubah Profile';
        $data['profile']    = DB::table('tbluser')->where('id', Auth::user()->id)->first();

        return view('Auth.ubahprofile', $data);
    }

    public function ubahProfilePost(Request $request){
        // cek jika ada foto
        $foto= $request->foto;
        if($foto != null){
            $fotoBaru = rand().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('foto/'), $fotoBaru);
            
            $ubahDataUser = DB::table('tbluser')->where('id', Auth::user()->id)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'foto'          => $fotoBaru,
            ]);
        }else{
            $ubahDataUser = DB::table('tbluser')->where('id', Auth::user()->id)->update([
                'nama'          => $request->nama,
                'email'         => $request->email,
                'no_telp'       => $request->no_telp,
                'tgl_lahir'     => $request->tgl_lahir,
                'umur'          => $request->umur,
                'nik'           => $request->nik,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
            ]);
        }

        if($ubahDataUser){
            return back()->with('success', 'Berhasil Update Profile!');
        }else{
            return back()->with('success', 'Gagal Update Profile!');
        }
    }

    public function ubahPassword(Request $request){
        if(Hash::check($request->password_lama, Auth::user()->password)){
            if($request->password_baru != null && $request->konfirmasi_password_baru != null){
                if($request->password_baru == $request->konfirmasi_password_baru){
                    $ubahPassword = DB::table('tbluser')
                        ->where('id', Auth::user()->id)->update([
                            'password' => bcrypt($request->password_baru)
                        ]);
                    
                    if($ubahPassword){
                        return back()->with('success', 'Password Berhasil Diubah!');
                    }else{
                        return back()->with('warning', 'Gagal Ubah Password!');
                    }
                }else{
                    return back()->with('warning', 'Maaf Konfirmasi Password Baru Tidak Sama!');
                }
            }else{
                return back()->with('warning', 'Silahkan Isi Password / Konfirmasi Password Baru!');
            }
        }else{
            return back()->with('warning', 'Maaf Password Lama Salah!');
        }
    }
}