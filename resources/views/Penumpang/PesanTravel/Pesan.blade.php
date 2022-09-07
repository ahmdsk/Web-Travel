@extends('layouts.Template')
@section('Konten')
<!-- ROW-1 OPEN -->
<div class="row">
    <div class="col-xl-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Atur Destinasi Perjalanan Ke {{$mobil->nama_destinasi}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <h5 class="fw-bold">Informasi Kendaraan</h5>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Merk Mobil</label>
                            <input type="text" class="form-control" name="merk_mobil" value="{{$mobil->merk_mobil}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Warna Mobil</label>
                            <input type="text" class="form-control" name="warna_mobil" value="{{$mobil->warna_mobil}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">No Polisi</label>
                            <input type="text" class="form-control" name="merk_mobil" value="{{$mobil->no_polisi}}" readonly>
                        </div>
                    </div>
                    <hr>
                    <h5 class="fw-bold">Penjemputan Dan Destinasi</h5>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Pilih Kota <span class="text-red">*</span></label>
                            <select class="form-select" name="kota" required>
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
                            <select class="form-select" name="kecamatan" required>
                                <option selected disabled>Pilih Kecamatan</option>
                                @forelse ($kecamatan as $k)
                                <option value="{{$k}}">{{$k}}</option>
                                @empty
                                <option>Tidak Ada Data</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Destinasi</label>
                            <input type="text" class="form-control" name="destinasi" value="{{$mobil->nama_destinasi}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Alamat <span class="text-red">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Alamat (Link Google Maps) <span class="text-red">(Opsional)</span></label>
                            <textarea class="form-control" rows="5" placeholder="https://goo.gl/maps/aaaa"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary">Pesan</button>
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
                <div class="row">
                    @for ($i = 1; $i <= $mobil->jumlah_kursi; $i++)
                    <div class="col-md-4">
                        <label class="custom-control custom-checkbox-md">
                            <input type="checkbox" class="custom-control-input" name="no_kursi" value="{{$i}}">
                            <span class="custom-control-label">No.{{$i}}</span>
                        </label>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="card cart">
            <div class="card-header">
                <h3 class="card-title">Upload Bukti Bayar</h3>
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
                    <input type="file" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-1 CLOSED -->
@endsection