<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    function similarityDistance($preferences, $person1, $person2)
    {
        $similar = array();
        $sum = 0;

        // data pembilang, penyebut dipecah dan di ulang
        foreach ($preferences[$person1] as $key => $value) {
            // kemudian jika iduser sama dengan user yang lain
            if (array_key_exists($key, $preferences[$person2]))
                // maka similar nya dibuat 1 jika tidak maka 0
                $similar[$key] = 1;
                $nonsimilar[$key] = 0;
        }

        if (count($similar) == 0)
            return 0;

        foreach ($preferences[$person1] as $key => $value) {
            if (array_key_exists($key, $preferences[$person2]))
                $sum = $sum + pow($value - $preferences[$person2][$key], 2);
        }

        return  1 / (1 + sqrt($sum));
    }

    function getRecommendations($preferences, $person)
    {
        $total = array();
        $simSums = array();
        $ranks = array();
        $sim = 0;

        foreach ($preferences as $otherPerson => $values) {
            // jika user yang sedang login tidak sama dengan user lain
            if ($otherPerson != $person) {
                // maka panggil function dibawah untuk mencari nilai rata"
                // isi nya ($preferences = nilai[idUser][idPesanan]/Pembilang-Penyebut)
                $sim = $this->similarityDistance($preferences, $person, $otherPerson);
            }

            if ($sim > 0) {
                foreach ($preferences[$otherPerson] as $key => $value) {
                    if (!array_key_exists($key, $preferences[$person])) {
                        if (!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }
                        $total[$key] += $preferences[$otherPerson][$key] * $sim;

                        if (!array_key_exists($key, $simSums)) {
                            $simSums[$key] = 0;
                        }
                        $simSums[$key] += $sim;
                    }
                }
            }
        }

        foreach ($total as $key => $value) {
            $ranks[$key] = $value / $simSums[$key];
        }

        return $ranks;
    }

    function ambilKecamatan(Request $request){
        $kecamatan  = DB::table('tblpenjemputan')->where('nama_kota', $request->kota)->distinct('kecamatan')->get();
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

    function waktujemput(Request $request){
        $waktuJemput = DB::table('tblwaktu_penjemputan')
                ->where('id_penjemputan', $request->idjemput)->get();
        
        return response()->json([
            'status' => 200,
            'data'   => $waktuJemput
        ]);
    }

    public function uploadBuktiBayar(Request $request){
        $file = $request->bukti_bayar;
        if($file != null){
            $newFile = rand().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('bukti_bayar/'), $newFile);

            $updateBukti = DB::table('tblpemesanan')
                    ->where('id_pesanan', $request->id_pesanan)
                    ->update([
                        'bukti_bayar' => $newFile
                    ]);

            if($updateBukti){
                return back()->with('success', 'Berhasil Update Bukti Bayar!');
            }else{
                return back()->with('warning', 'Gagal Update Bukti Bayar!');
            }
        }else{
            return back()->with('warning', 'Gagal Mengupload Bukti Bayar!');
        }
    }

    public function pesan(){
        $data['title']       = 'Pesan Travel';
        $data['ibukota']     = DB::table('tblpenjemputan')->distinct('nama_kota')->pluck('nama_kota');
        $data['kecamatan']   = DB::table('tblpenjemputan')->distinct('kecamatan')->pluck('kecamatan');
        $data['destinasi']   = DB::table('destinasi')->distinct('nama_destinasi')->pluck('nama_destinasi');
        $data['listMobil']   = DB::table('destinasi')
                    ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                    ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                    ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->select('destinasi.*', 'tblmobil.*', 'tbldriver.*', 'tblperusahaan.*', 'tbluser.nama')
                    ->orderBy('destinasi.id', 'desc')
                    ->get();

        // data collaborative filtering
        // semua userr
        $users = DB::table('tbluser')->where('role', 'Penumpang')->get();

        // user yang telah login
        $userLogin = Auth::user();

        // cek pesanan user yang telah login
        if($userLogin){
            $cekPesananUserLogin = DB::table('tblpemesanan')->where('user_id', $userLogin->id)->get();
        }else{
            $cekPesananUserLogin = [];
        }

        $data['rekomendasi'] = [];
        $dataRekomendasi = [];
        if(count($cekPesananUserLogin) > 0){
            foreach($users as $u){
                $pesanan = DB::table('tblpemesanan')->where('user_id', $u->id)->get();
                foreach($pesanan as $psn){
                    $rating = DB::table('tblrating')
                            ->where('id_pesanan', $psn->id_pesanan)
                            ->where('id_user', $u->id)
                            ->select('rating')->pluck('rating')->first();
    
                    // $u->id = id user dari semua user yang telah memesan travel
                    // $psn->destinasi_id = destinasi yang telah dipesan oleh semua user
                    // $rating = dapat dari rating yang telah semua user berikan

                    $dataRekomendasi[$u->id][$psn->destinasi_id] = $rating;
                }   
            }

            // panggil function untuk cek data pembilang, dan penyebut serta user yang ingin di cek (user login)
            $rekomendasi = $this->getRecommendations($dataRekomendasi, $userLogin->id);

            foreach($rekomendasi as $id_destinasi => $rating){
                $produkRekomendasi   = DB::table('destinasi')
                            ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                            ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                            ->select('destinasi.*', 'tblmobil.*', 'tbldriver.*', 'tblperusahaan.*')
                            ->where('destinasi.id', $id_destinasi)
                            ->get();

                foreach($produkRekomendasi as $pr){
                    array_push($data['rekomendasi'], [
                        'id'                => $pr->id_mobil,
                        'foto_mobil'        => $pr->foto_mobil,
                        'nama_destinasi'    => $pr->nama_destinasi,
                        'harga_destinasi'   => $pr->harga_destinasi,
                        'jumlah_kursi'      => $pr->jumlah_kursi,
                        'merk_mobil'        => $pr->merk_mobil,
                        'warna_mobil'       => $pr->warna_mobil,
                        'nama_perusahaan'   => $pr->nama_perusahaan
                    ]);
                }
            }
        }else{
            $rekomendasi = [];
        }
        // end data collaborative filtering

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
                ->orderBy('tblpemesanan.id_pesanan', 'desc')
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
                    ->join('tbluser', 'tbluser.id', '=', 'tbldriver.user_id')
                    ->select('destinasi.*', 'tblmobil.*', 'tbldriver.*', 'tblperusahaan.*', 'tbluser.nama')
                    ->where('destinasi.id', $id)
                    ->orderBy('destinasi.id', 'desc')
                    ->first();

        $jumlahRating = DB::table('tblrating')
                    ->join('tblpemesanan', 'tblpemesanan.id_pesanan', '=', 'tblrating.id_pesanan')
                    ->where('mobil_id', $id)->count();
        $dataRating = DB::table('tblrating')
                    ->join('tblpemesanan', 'tblpemesanan.id_pesanan', '=', 'tblrating.id_pesanan')
                    ->where('mobil_id', $id)->sum('rating');

        if($jumlahRating != 0 && $dataRating != 0){
            $data['rating'] = $dataRating / $jumlahRating;
        }else{
            $data['rating'] = 0;
        }

        $data['cekKursi'] = DB::table('tblpemesanan')->where('mobil_id', $id)->whereIn('status_bayar', ['Pending', 'Terkonfirmasi'])->get();
                    
        $data['rekening'] = DB::table('tblpembayaran_perusahaan')->where('perusahaan_id', $data['mobil']->perusahaan_id)->get();

        return view('Penumpang.PesanTravel.Pesan', $data);
    }

    public function pesanTravelPost(Request $request){
        $file_bukti = $request->bukti_bayar;

        if($request->no_kursi == null){
            return back()->with('warning', 'Silahkan Pilih Kursi!');
        }

        // cek apakah kursi kosong
        $cekKursi = DB::table('tblpemesanan')
                ->where('mobil_id', $request->id_mobil)
                ->where('no_kursi', $request->no_kursi)
                ->whereIn('status_bayar', ['Pending', 'Terkonfirmasi'])
                ->get();

        if(count($cekKursi) < 1){

            if($file_bukti != null){
                $file_bukti_baru = rand().'.'.$file_bukti->getClientOriginalExtension();
                $file_bukti->move(public_path('bukti_bayar/'), $file_bukti_baru);

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
            }else{
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
                    'url_alamat'            => $request->url_alamat
                ]);
            }

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