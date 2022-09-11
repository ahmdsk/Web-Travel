@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="card p-5">
    <form action="#" method="GET" id="formSearchTravel">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="">Pilih Kota Penjemputan</label>
                <select class="form-select" name="kota" required>
                    <option selected disabled>Pilih Kota</option>
                    @forelse ($ibukota as $ib)
                    <option value="{{$ib}}">{{$ib}}</option>
                    @empty
                    <option>Tidak Ada Data</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Pilih Kecamatan Penjemputan</label>
                <select class="form-select" name="kecamatan" required>
                    <option selected disabled>Pilih Kecamatan</option>
                    @forelse ($kecamatan as $k)
                    <option value="{{$k}}">{{$k}}</option>
                    @empty
                    <option>Tidak Ada Data</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-3">
                <label for="">Destinasi Tujuan</label>
                {{-- <input type="text" class="form-control" name="destinasi" placeholder="Destinasi" required> --}}
                <select class="form-select" name="destinasi" required>
                    <option selected disabled>Pilih Destinasi</option>
                    @forelse ($destinasi as $d)
                    <option value="{{$d}}">{{$d}}</option>
                    @empty
                    <option>Tidak Ada Data</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-3 mt-2">
                <button type="submit" class="btn btn-primary fw-bold" style="width: 100%">Cari</button>
            </div>
        </div>
    </form>
</div>
@if (count($rekomendasi) > 0)
    <h3>Rekomendasi Untuk Kamu</h3>
    <div class="row">
        @foreach ($rekomendasi as $rekomenMobil)
        <div class="col-md-4">
            <div class="card overflow-hidden">
                @if ($rekomenMobil['foto_mobil'] != null)
                <img src="{{ asset('foto_mobil/'.$rekomenMobil['foto_mobil']) }}" class="card-img-top" alt="img">
                @else
                <img src="{{ asset('assets/images/media/8.jpg') }}" class="card-img-top" alt="img">
                @endif
                <div class="card-body">
                    <div class="card-title">
                        <span class="badge bg-danger badge-lg mb-3">Rekomendasi</span>
                        <h5>{{$rekomenMobil['nama_perusahaan']}}</h5>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Destinasi</td>
                            <td>:</td>
                            <td>{{$rekomenMobil['nama_destinasi']}}</td>
                          </tr>
                          <tr>
                            <td>Harga Destinasi</td>
                            <td>:</td>
                            <td>Rp. {{number_format($rekomenMobil['harga_destinasi'], 0)}}</td>
                          </tr>
                          <tr>
                            <td>Kursi Tersedia</td>
                            <td>:</td>
                            <td>{{$rekomenMobil['jumlah_kursi']}}</td>
                          </tr>
                          <tr>
                            <td>Keterangan Mobil</td>
                            <td>:</td>
                            <td>{{$rekomenMobil['merk_mobil']}} ({{$rekomenMobil['warna_mobil']}})</td>
                          </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <a href="{{route('penumpang.pesanTravel', $rekomenMobil['id'])}}" class="btn btn-success">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
<div id="data-mobil">
    <div class="row">
        @forelse ($listMobil as $mobil)
        <div class="col-md-4">
            <div class="card overflow-hidden">
                @if ($mobil->foto_mobil != null)
                <img src="{{ asset('foto_mobil/'.$mobil->foto_mobil) }}" class="card-img-top" alt="img">
                @else
                <img src="{{ asset('assets/images/media/8.jpg') }}" class="card-img-top" alt="img">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$mobil->nama_perusahaan}}</h5>
                    <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Nama Pengemudi</td>
                            <td>:</td>
                            <td>{{$mobil->nama}}</td>
                          </tr>
                          <tr>
                            <td>Destinasi</td>
                            <td>:</td>
                            <td>{{$mobil->nama_destinasi}}</td>
                          </tr>
                          <tr>
                            <td>Harga Destinasi</td>
                            <td>:</td>
                            <td>Rp. {{number_format($mobil->harga_destinasi, 0)}}</td>
                          </tr>
                          <tr>
                            <td>Kursi Tersedia</td>
                            <td>:</td>
                            <td>{{$mobil->jumlah_kursi}}</td>
                          </tr>
                          <tr>
                            <td>Keterangan Mobil</td>
                            <td>:</td>
                            <td>{{$mobil->merk_mobil}} ({{$mobil->warna_mobil}})</td>
                          </tr>
                        </tbody>
                    </table>
                    @php
                        $jumlahRating = DB::table('tblrating')
                                    ->join('tblpemesanan', 'tblpemesanan.id_pesanan', '=', 'tblrating.id_pesanan')
                                    ->where('mobil_id', $mobil->id_mobil)->count();
                        $dataRating = DB::table('tblrating')
                                    ->join('tblpemesanan', 'tblpemesanan.id_pesanan', '=', 'tblrating.id_pesanan')
                                    ->where('mobil_id', $mobil->id_mobil)->sum('rating');

                        if($jumlahRating != 0 && $dataRating != 0){
                            $rating = $dataRating / $jumlahRating;
                        }else{
                            $rating = 0;
                        }
                    @endphp
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h4>Rating: {{number_format($rating, 1)}}</h4>
                        <a href="{{route('penumpang.pesanTravel', $mobil->id)}}" class="btn btn-success">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12 text-center">
            <h5>Tidak Ada Data</h5>
        </div>
        @endforelse
    </div>
</div>
<!-- End Row -->
@endsection
@push('inc-js')
    <script>
        $('#formSearchTravel').submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: "{{route('penumpang.cari')}}",
                type: 'GET',
                data: $(this).serialize(),
                success: function(data){
                    $('#data-mobil').html(data);
                }
            });
        })
    </script>
@endpush