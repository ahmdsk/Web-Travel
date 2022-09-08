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
                                {{-- <th class="wd-15p border-bottom-0">Keterangan Mobil</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemesanan as $p)
                            <tr>
                                <td>{{$hari[date('N', strtotime($p->tgl_perjalanan))]}}, {{$p->tgl_perjalanan}}</td>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->nama_kota}}, {{$p->kecamatan}} - {{$p->nama_destinasi}}</td>
                                {{-- <td>({{$p->no_polisi}}) {{$p->merk_mobil}} - {{$p->warna_mobil}}</td> --}}
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="4">Tidak ada data</td>
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