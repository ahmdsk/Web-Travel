@extends('layouts.Template')
@section('Konten')
<!-- ROW-1 OPEN -->
<form action="{{route('penumpang.pesanTravelPost')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_mobil" value="{{$mobil->mobil_id}}">
    <input type="hidden" name="destinasi_id" value="{{$mobil->id}}">
    <input type="hidden" name="penjemputan_id" id="penjemputan_id">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="width: 100%">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Atur Destinasi Perjalanan Ke {{$mobil->nama_destinasi}}</h3>
                            <h3 style="color: gold" class="fw-bold">Rating: {{number_format($rating, 1)}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <h5 class="fw-bold">Informasi Kendaraan</h5>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Pengemudi</label>
                                <input type="text" class="form-control" name="merk_mobil" value="{{$mobil->nama}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Merk Mobil</label>
                                <input type="text" class="form-control" name="merk_mobil" value="{{$mobil->merk_mobil}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Warna Mobil</label>
                                <input type="text" class="form-control" name="warna_mobil" value="{{$mobil->warna_mobil}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">No Polisi</label>
                                <input type="text" class="form-control" name="no_polisi" value="{{$mobil->no_polisi}}" readonly>
                            </div>
                        </div>
                        <hr>
                        <h5 class="fw-bold">Penjemputan Dan Destinasi</h5>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Pilih Kota <span class="text-red">*</span></label>
                                <select class="form-select" name="kota" required id="selectKota">
                                    <option selected disabled>Pilih Kota</option>
                                    @forelse ($ibukota as $ib)
                                    <option value="{{$ib}}">{{$ib}}</option>
                                    @empty
                                    <option>Tidak Ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Pilih Kecamatan <span class="text-red">*</span></label>
                                <select class="form-select" name="kecamatan" required id="selectKecamatan">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Harga Penjemputan</label>
                                <input type="text" class="form-control" name="harga_jemput" value="" id="harga_jemput" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Destinasi</label>
                                <input type="text" class="form-control" name="destinasi" value="{{$mobil->nama_destinasi}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Harga Destinasi</label>
                                <input type="text" class="form-control" name="harga_destinasi" id="harga_destinasi" value="{{$mobil->harga_destinasi}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Waktu Keberangkatan</label>
                                <select name="waktu_jemput" class="form-select" id="waktu_jemput">
                                    {{-- @foreach ($waktuJemput as $wj)
                                    <option value="{{$wj->waktu_penjemputan}}">{{$wj->waktu_penjemputan}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Fasilitas</label>
                                <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="{{$mobil->fasilitas}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap Serta Patokan Penjemputan <span class="text-red">*</span></label>
                                <textarea class="form-control" rows="5" name="alamat" placeholder="Alamat" required>{{Auth::user()->alamat != null ? Auth::user()->alamat : ''}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Alamat (Link Google Maps)</label>
                                <textarea class="form-control" rows="5" name="url_alamat" placeholder="https://goo.gl/maps/xxxx"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Bayar</label>
                                <input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Perjalanan <span class="text-red">*</span></label>
                                <input type="date" class="form-control" name="tgl_perjalanan" id="tgl_perjalanan" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Pilih Kursi</h3>
                </div>
                <div class="card-body">
                    <p>Silahkan Pilih Kursi! <span class="text-muted">(Mohon Pilih Kursi Yang Belum Di Cek!)</span></p>
                    <p><span style="color: red"><b>Perhatian!</b> Semakin Kecil No Kursi, Menandakan Duduk Di Depan.</span></p>
                    <div class="row">
                        @for ($i = 1; $i <= $mobil->jumlah_kursi; $i++)
                            @if (count($cekKursi) > 0)
                            <div class="col-md-4">
                                <label class="custom-control custom-checkbox-md">
                                @foreach ($cekKursi as $kursi)
                                        <input type="checkbox" {{$i == $kursi->no_kursi ? 'checked disabled' : ''}} class="custom-control-input" name="no_kursi" value="{{$i}}">
                                @endforeach
                                <span class="custom-control-label">No.{{$i}}</span>
                                </label>
                            </div>
                            @else
                            <div class="col-md-4">
                                <label class="custom-control custom-checkbox-md">
                                    <input type="checkbox" class="custom-control-input" name="no_kursi" value="{{$i}}">
                                    <span class="custom-control-label">No.{{$i}}</span>
                                </label>
                            </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Upload Bukti Bayar (Opsional)</h3>
                </div>
                <div class="card-body">
                    <div class="">
                        <h4 class="fw-semibold">Rekening:</h4>
                        @forelse ($rekening as $r)
                        <p>{{$r->nama_bank }} - {{$r->no_rekening}} ({{$r->nama_pemilik}})</p>
                        @empty
                        <p>Belum Ada Rekening Tertaut</p>
                        @endforelse
                    </div>
    
                    <div class="mt-3">
                        <label for="">Upload Bukti Bayar (Maksimal 2 MB)</label>
                        <input type="file" name="bukti_bayar" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- ROW-1 CLOSED -->
@endsection
@push('inc-js')
    <script>
        $('#selectKota').change(function(){
            $.ajax({
                type: 'GET',
                url: "{{route('penumpang.kecamatan')}}",
                data: {
                    'kota': $('#selectKota').val()
                },
                success: function(json){
                    if(json.status == 200){
                        Object.values(json.data).forEach(data => {
                            $('#selectKecamatan').append(`<option value="${data.kecamatan}">${data.kecamatan}</option>`);
                            $('#selectKecamatan').data('idjemput', data.id);
                        });
                    }
                }
            })
        });

        $('#selectKecamatan').click(function(){
            $.ajax({
                type: 'GET',
                url: "{{route('penumpang.cekharga')}}",
                data: {
                    'kecamatan': $('#selectKecamatan').val()
                },
                success: function(json){
                    if(json.status == 200){
                        $('#penjemputan_id').val(json.data.id);
                        $('#harga_jemput').val(json.data.harga);

                        $('#total_bayar').val(Number($('#harga_jemput').val()) + Number($('#harga_destinasi').val()));

                        $.ajax({
                            type: 'GET',
                            url: "{{route('penumpang.waktujemput')}}",
                            data: {
                                'idjemput': $('#selectKecamatan').data('idjemput')
                            },
                            success: function(json2){
                                if(json2.status == 200){
                                    $('#waktu_jemput').empty();
                                    Object.values(json2.data).forEach(data2 => {
                                        $('#waktu_jemput').append(`<option value="${data2.waktu_penjemputan}">${data2.waktu_penjemputan}</option>`);
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush