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
                <div class="d-flex justify-content-end">
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