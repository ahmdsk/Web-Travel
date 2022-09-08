@extends('layouts.Template')
@section('Konten')
@php
    $hari = [
        1 =>'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
    ];
@endphp
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Tanggal Perjalanan</th>
                                <th class="wd-15p border-bottom-0">Nama Penumpang</th>
                                <th class="wd-15p border-bottom-0">Penjemputan - Destinasi</th>
                                <th class="wd-15p border-bottom-0">Keterangan Mobil</th>
                                <th class="wd-15p border-bottom-0">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemesanan as $p)
                            <tr>
                                <td>{{$hari[date('N', strtotime($p->tgl_perjalanan))]}}, {{$p->tgl_perjalanan}}</td>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->nama_kota}}, {{$p->kecamatan}} - {{$p->nama_destinasi}}</td>
                                <td>({{$p->no_polisi}}) {{$p->merk_mobil}} - {{$p->warna_mobil}}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detail-{{$p->id_pesanan}}">Detail Alamat</a>
                                </td>
                                <div class="modal fade" id="detail-{{$p->id_pesanan}}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Detail Alamat</h6>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label">Alamat</label>
                                                            <textarea class="form-control" readonly>{{$p->detail_penjemputan}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="col-form-label">Alamat (Link Google Maps)</label>
                                                        @if ($p->url_alamat != null)
                                                            <a href="{{$p->url_alamat}}" target="_blank" class="btn btn-sm btn-primary" style="width: 100%">Cek Alamat</a>
                                                        @else
                                                            <button class="btn btn-sm btn-primary" style="width: 100%" disabled>Tidak Ada Data</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="5">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection