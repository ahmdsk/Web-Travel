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
                                        Tidak Ada Bukti Bayar <br>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadBuktiBayar-{{$p->id_pesanan}}">Upload Bukti</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($p->status_bayar == 'Pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($p->status_bayar == 'Terkonfirmasi')
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                    @elseif ($p->status_bayar == 'Selesai')
                                        @if ($p->rating == null)
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#rating-{{$p->id_pesanan}}"
                                        class="btn btn-sm btn-primary">Beri Nilai</a>
                                        @else
                                        <button class="btn btn-sm btn-primary" disabled>Sudah Memberi Nilai</button>
                                        @endif
                                    @endif
                                </td>

                                <div class="modal fade" id="rating-{{$p->id_pesanan}}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Beri Rating Pesanan</h6>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{route('rating', $p->id_pesanan)}}" method="post">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <div class="mb-3">
                                                                    <h5>Keterangan Rating: </h5>
                                                                    <ul>
                                                                        <li>5 (Sangat Puas)</li>
                                                                        <li>4 (Puas)</li>
                                                                        <li>3 (Cukup Puas)</li>
                                                                        <li>2 (Tidak Puas)</li>
                                                                        <li>1 (Sangat Tidak Puas)</li>
                                                                    </ul>
                                                                </div>
                                                                <label for="rating" class="col-form-label">Rating / Ulasan</label>
                                                                <input class="form-control" type="number" name="rating" id="rating" min="1" max="5" placeholder="Beri Nilai Rating Anda Disini!">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="col-form-label">Keterangan (Opsional)</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Tulis Saran"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn ripple btn-success" type="submit" id="btnRating">Beri Rating</button>
                                                    <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="uploadBuktiBayar-{{$p->id_pesanan}}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Upload Bukti Pembayaran</h6>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{route('uploadBuktiBayar')}}" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id_pesanan" value="{{$p->id_pesanan}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="bukti_bayar" class="col-form-label text-center">Upload Bukti Bayar <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                                                <input class="form-control" type="file" name="bukti_bayar" id="bukti_bayar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn ripple btn-success" type="submit">Upload</button>
                                                    <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="9">Tidak ada data</td>
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