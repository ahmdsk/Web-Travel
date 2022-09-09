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
                                <th class="wd-15p border-bottom-0">Nama Perusahaan</th>
                                <th class="wd-15p border-bottom-0">Nama Penumpang</th>
                                <th class="wd-15p border-bottom-0">Penjemputan - Destinasi</th>
                                <th class="wd-20p border-bottom-0">Status</th>
                                <th class="wd-15p border-bottom-0">Keterangan Mobil</th>
                                <th class="wd-15p border-bottom-0">Tanggal Perjalanan</th>
                                <th class="wd-15p border-bottom-0">Total Harga</th>
                                <th class="wd-15p border-bottom-0">Bukti Bayar</th>
                                <th class="wd-15p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemesanan as $p)
                            <tr>
                                <td>{{$p->nama_perusahaan}}</td>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->nama_kota}}, {{$p->kecamatan}} - {{$p->nama_destinasi}}</td>
                                <td class="text-center">
                                    @if ($p->status_bayar == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($p->status_bayar == 'Terkonfirmasi')
                                    <span class="badge bg-success">Selesai</span>
                                    @elseif ($p->status_bayar == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td>({{$p->no_polisi}}) {{$p->merk_mobil}} - {{$p->warna_mobil}}</td>
                                <td>{{$hari[date('N', strtotime($p->tgl_perjalanan))]}}, {{$p->tgl_perjalanan}}</td>
                                <td>Rp. {{number_format($p->total_harga, 0)}}</td>
                                <td>
                                    @if ($p->bukti_bayar != null)
                                        <a href="{{asset('bukti_bayar/'.$p->bukti_bayar)}}" target="_blank">
                                            <img src="{{asset('bukti_bayar/'.$p->bukti_bayar)}}" style="width: 100px">
                                        </a>
                                    @else
                                        Tidak Ada Gambar
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#konfirmasi-{{$p->id_pesanan}}">Konfirmasi Pembayaran</button>

                                    <div class="modal fade" id="konfirmasi-{{$p->id_pesanan}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">{{$title}}</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('pembayaran.konfirmasi')}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_pesanan" value="{{$p->id_pesanan}}">
                                                        <input type="hidden" name="status_bayar" value="Terkonfirmasi">

                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <div>
                                                                <button class="btn ripple btn-success" type="submit">Simpan</button>
                                                                <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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