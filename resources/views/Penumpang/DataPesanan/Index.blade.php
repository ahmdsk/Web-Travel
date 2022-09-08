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
                                <th class="wd-15p border-bottom-0">Destinasi</th>
                                <th class="wd-15p border-bottom-0">Penjemputan</th>
                                <th class="wd-15p border-bottom-0">No Kursi</th>
                                <th class="wd-15p border-bottom-0">Total Harga</th>
                                <th class="wd-20p border-bottom-0">Keterangan Mobil</th>
                                <th class="wd-20p border-bottom-0">Foto Mobil</th>
                                <th class="wd-25p border-bottom-0">Bukti Bayar</th>
                                <th class="wd-20p border-bottom-0">Status Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesanan as $p)
                            <tr>
                                <td>{{$hari[date('N', strtotime($p->tgl_perjalanan))]}}, {{$p->tgl_perjalanan}}</td>
                                <td>{{$p->nama_destinasi}}</td>
                                <td>{{$p->nama_kota}}, {{$p->kecamatan}}</td>
                                <td>{{$p->no_kursi}}</td>
                                <td>Rp. {{number_format($p->total_harga, 0)}}</td>
                                <td>({{$p->no_polisi}}) {{$p->merk_mobil}} - {{$p->warna_mobil}}</td>
                                <td>
                                    @if ($p->foto_mobil != null)
                                        <img src="{{asset('foto_mobil/'.$p->foto_mobil)}}" style="width: 100px">
                                    @else
                                        Tidak Ada Gambar
                                    @endif
                                </td>
                                <td>
                                    @if ($p->bukti_bayar != null)
                                        <img src="{{asset('bukti_bayar/'.$p->bukti_bayar)}}" style="width: 100px">
                                    @else
                                        Tidak Ada Bukti Bayar
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($p->status_bayar == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($p->status_bayar == 'Terkonfirmasi')
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                    @elseif ($p->status_bayar == 'Selesai')
                                    <a href="#" class="btn btn-sm btn-primary">Beri Nilai</a>
                                    @endif
                                </td>
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