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

        foreach ($preferences[$person1] as $key => $value) {
            if (array_key_exists($key, $preferences[$person2]))
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


    public function matchItems($preferences, $person)
    {
        $score = array();

        foreach ($preferences as $otherPerson => $values) {
            if ($otherPerson !== $person) {
                $sim = $this->similarityDistance($preferences, $person, $otherPerson);

                if ($sim > 0)
                    $score[$otherPerson] = $sim;
            }
        }

        array_multisort($score, SORT_DESC);
        return $score;
    }

    public function transformPreferences($preferences)
    {
        $result = array();

        foreach ($preferences as $otherPerson => $values) {
            foreach ($values as $key => $value) {
                $result[$key][$otherPerson] = $value;
            }
        }

        return $result;
    }


    public function getRecommendations($preferences, $person)
    {
        $total = array();
        $simSums = array();
        $ranks = array();
        $sim = 0;

        foreach ($preferences as $otherPerson => $values) {
            if ($otherPerson != $person) {
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
    
                    $dataRekomendasi[$u->id][$psn->id_pesanan] = $rating;
                }   
            }

            $rekomendasi = $this->getRecommendations($dataRekomendasi, $userLogin->id);

            // foreach($rekomendasi as $idProduk => $rating){
            //     $produkRekomendasi   = DB::table('destinasi')
            //                 ->join('tblmobil', 'tblmobil.id_mobil', '=', 'destinasi.mobil_id')
            //                 ->join('tbldriver', 'tbldriver.id_driver', '=', 'tblmobil.driver_id')
            //                 ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tbldriver.perusahaan_id')
            //                 ->orderBy('destinasi.id', 'desc')
            //                 ->get();

            //     // foreach($produkRekomendasi as $pr){
            //     //     $dataRating = DB::table('product_ratings')->where('id_product', $pr->id)->pluck('ratings');
                
            //     //     if(count($dataRating) > 0){
            //     //         array_push($data['rekomendasi'], [
            //     //             'id'            => $pr->id,
            //     //             'product_name'	=> $pr->product_name,
            //     //             'product_price'	=> $pr->product_price,
            //     //             'category_id'   => $pr->category_id,
            //     //             'gambar'	    => $pr->gambar,
            //     //             'jenis_gambar'	=> $pr->jenis_gambar,
            //     //             'jumlah_rating' => [
            //     //                 'rating'    => array_sum(DB::table('product_ratings')->where('id_product', $pr->id)->pluck('ratings')->toArray()) / DB::table('product_ratings')->where('id_product', $pr->id)->count()
            //     //             ]
            //     //         ]);
            //     //     }else{
            //     //         array_push($data['rekomendasi'], [
            //     //             'id'            => $pr->id,
            //     //             'product_name'	=> $pr->product_name,
            //     //             'product_price'	=> $pr->product_price,
            //     //             'category_id'   => $pr->category_id,
            //     //             'gambar'	    => $pr->gambar,
            //     //             'jenis_gambar'	=> $pr->jenis_gambar,
            //     //             'jumlah_rating' => [
            //     //                 'rating'    => 0
            //     //             ]
            //     //         ]);
            //     //     }
            //     // }
            // }
        }else{
            $rekomendasi = [];
        }
        // end data collaborative filtering
    }
}
