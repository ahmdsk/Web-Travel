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
                                <th class="wd-15p border-bottom-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $r)
                            <tr>
                                <td>{{$hari[date('N', strtotime($r->tgl_perjalanan))]}}, {{$r->tgl_perjalanan}}</td>
                                <td>{{$r->nama}}</td>
                                <td>{{$r->nama_kota}}, {{$r->kecamatan}} - {{$r->nama_destinasi}}</td>
                                <td>({{$r->no_polisi}}) {{$r->merk_mobil}} - {{$r->warna_mobil}}</td>
                                <td><span class="badge bg-success badge-sm me-1 mb-1 mt-1">{{$r->status_bayar}}</span></td>
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