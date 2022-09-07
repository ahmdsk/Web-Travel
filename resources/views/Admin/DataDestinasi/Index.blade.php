@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah Destinasi</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Nama Pengemudi</th>
                                <th class="wd-15p border-bottom-0">Keterangan Mobil</th>
                                <th class="wd-15p border-bottom-0">Nama Destinasi</th>
                                <th class="wd-20p border-bottom-0">Harga Destinasi</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($destinasi as $d)
                            <tr>
                                <td>{{$d->nama}}</td>
                                <td>{{$d->no_polisi}} - {{$d->merk_mobil}} ({{$d->warna_mobil}})</td>
                                <td>{{$d->nama_destinasi}}</td>
                                <td>Rp. {{number_format($d->harga_destinasi, 0)}}</td>
                                <td>
                                    <div class="btn-group mt-2 mb-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                Opsi <span class="caret"></span>
                                            </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{$d->id}}">Edit</a></li>
                                            <li><a href="#" onclick="hapusModal('{{$d->id}}')">Hapus</a></li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$d->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit Destinasi</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('destinasi.edit')}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_destinasi" value="{{$d->id}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_destinasi" class="col-form-label">Nama Destinasi</label>
                                                                    <input type="text" class="form-control" id="nama_destinasi" name="nama_destinasi" value="{{$d->nama_destinasi}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="harga_destinasi" class="col-form-label">Harga Destinasi</label>
                                                                    <input type="number" class="form-control" id="harga_destinasi" name="harga_destinasi" value="{{$d->harga_destinasi}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="id_mobil" class="col-form-label">Mobil Travel</label> <br>
                                                                    <select id="id_mobil" name="id_mobil" class="form-select">
                                                                        @php
                                                                            $idMobilTerpilih = $d->mobil_id;
                                                                        @endphp
                                                                        @forelse ($mobil as $m)
                                                                            @if ($m->id_mobil == $idMobilTerpilih)
                                                                            <option value="{{$idMobilTerpilih}}" selected>{{$m->no_polisi}} - {{$m->merk_mobil}} ({{$m->nama}})</option>
                                                                            @else
                                                                            <option value="{{$m->id_mobil}}">{{$m->no_polisi}} - {{$m->merk_mobil}} ({{$m->nama}})</option>
                                                                            @endif
                                                                        @empty
                                                                            <option>Tidak Ada Data</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-success" type="submit">Edit</button>
                                                        <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
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

<!-- Inout modal -->
<div class="modal fade" id="input-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Destinasi</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('destinasi.tambah')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_destinasi" class="col-form-label">Nama Destinasi</label>
                                <input type="text" class="form-control" id="nama_destinasi" name="nama_destinasi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_destinasi" class="col-form-label">Harga Destinasi</label>
                                <input type="number" class="form-control" id="harga_destinasi" name="harga_destinasi">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="id_mobil" class="col-form-label">Mobil Travel</label>
                                <select id="id_mobil" name="id_mobil" class="form-select">
                                    <option selected disabled>Pilih Mobil</option>
                                    @forelse ($mobil as $m)
                                        <option value="{{$m->id_mobil}}">{{$m->no_polisi}} - {{$m->merk_mobil}} ({{$m->nama}})</option>
                                    @empty
                                        <option>Tidak Ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="submit">Simpan</button>
                    <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('inc-js')
<script>
    function hapusModal(id){
        Swal.fire({
            icon: 'question',
            title: 'Hapus Data?',
            text: 'Yakin ingin hapus data ini?',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('/data-destinasi/hapus')}}"+"/"+id,
                    success: function(json){
                        if(json.status == 200){
                            Swal.fire('Berhasil Hapus Data!', '', 'success');
                            location.reload();
                        }
                    },
                    error: function(err){
                        if(json.status == 500){
                            Swal.fire('Gagal Hapus Data!', '', 'warning');
                            location.reload();
                        }
                    }
                });
            }
        })
    }
</script>
@endpush