<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    public function similarityDistance($preferences, $person1, $person2)
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

    public function getRecommendations($preferences, $person)
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

        array_multisort($ranks, SORT_DESC);
        return $ranks;
    }

    public function rekomendasi()
    {
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
                    // $psn->id_pesanan = id pesanan yang telah dipesan oleh semua user
                    // $rating = dapat dari rating yang telah semua user berikan

                    $dataRekomendasi[$u->id][$psn->id_pesanan] = $rating;
                }   
            }

            // panggil function untuk cek data pembilang, dan penyebut serta user yang ingin di cek (user login)
            $rekomendasi = $this->getRecommendations($dataRekomendasi, $userLogin->id);

            foreach($rekomendasi as $idpesanan => $rating){
                $produkRekomendasi   = DB::table('destinasi')
                            ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
                            ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
                            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
                            ->join('tblpemesanan', 'tblpemesanan.destinasi_id', '=', 'destinasi.id')
                            ->where('id_pesanan', $idpesanan)
                            ->get();

                foreach($produkRekomendasi as $pr){
                    $dataRating = DB::table('tblrating')->where('id_pesanan', $pr->id_pesanan)->pluck('rating');
                
                    if(count($dataRating) > 0){
                        array_push($data['rekomendasi'], [
                            'id'            => $pr->id,
                            'product_name'	=> $pr->product_name,
                            'product_price'	=> $pr->product_price,
                            'category_id'   => $pr->category_id,
                            'gambar'	    => $pr->gambar,
                            'jenis_gambar'	=> $pr->jenis_gambar,
                            'jumlah_rating' => [
                                'rating'    => array_sum(DB::table('tblrating')->where('id_pesanan', $pr->id_pesanan)->pluck('rating')->toArray()) / DB::table('tblrating')->where('id_pesanan', $pr->id_pesanan)->count()
                            ]
                        ]);
                    }else{
                        array_push($data['rekomendasi'], [
                            'id'            => $pr->id,
                            'product_name'	=> $pr->product_name,
                            'product_price'	=> $pr->product_price,
                            'category_id'   => $pr->category_id,
                            'gambar'	    => $pr->gambar,
                            'jenis_gambar'	=> $pr->jenis_gambar,
                            'jumlah_rating' => [
                                'rating'    => 0
                            ]
                        ]);
                    }
                }
            }
        }else{
            $rekomendasi = [];
        }
        // end data collaborative filtering
    }
}
