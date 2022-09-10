@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah Mobil Travel</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">No Polisi</th>
                                <th class="wd-15p border-bottom-0">Merk Mobil</th>
                                <th class="wd-20p border-bottom-0">Warna Mobil</th>
                                <th class="wd-15p border-bottom-0">Kapasitas</th>
                                <th class="wd-15p border-bottom-0">Pengemudi</th>
                                <th class="wd-15p border-bottom-0">Foto Mobil</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mobil as $m)
                            <tr>
                                <td>{{$m->no_polisi}}</td>
                                <td>{{$m->merk_mobil}}</td>
                                <td>{{$m->warna_mobil}}</td>
                                <td>{{$m->jumlah_kursi}}</td>
                                <td>{{$m->nama}}</td>
                                <td>
                                    @if ($m->foto_mobil != null)
                                        <a href="{{asset('foto_mobil/'.$m->foto_mobil)}}" target="_blank"><img src="{{asset('foto_mobil/'.$m->foto_mobil)}}" alt="Gambar {{$m->merk_mobil}}" style="width: 100px"></a>
                                    @else
                                        Gambar Tidak Ada
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group mt-2 mb-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                Opsi <span class="caret"></span>
                                            </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{$m->id_mobil}}">Edit</a></li>
                                            <li><a href="#" onclick="hapusModal('{{$m->id_mobil}}')">Hapus</a></li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$m->id_mobil}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit {{$title}}</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('mobil.edit')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_mobil" value="{{$m->id_mobil}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="id_perusahaan" class="col-form-label">Nama Perusahaan</label> <br>
                                                                    <select id="id_perusahaan" name="id_perusahaan" class="form-select">
                                                                        @php
                                                                            $idPerusahaanTerpilih = $m->id_perusahaan;
                                                                        @endphp
                                                                        @forelse ($perusahaan as $p)
                                                                            @if ($p->id_perusahaan == $idPerusahaanTerpilih)
                                                                            <option value="{{$idPerusahaanTerpilih}}" selected>{{$p->nama_perusahaan}}</option>
                                                                            @else
                                                                            <option value="{{$p->id_perusahaan}}">{{$p->nama_perusahaan}}</option>
                                                                            @endif
                                                                        @empty
                                                                        <option value="">Tidak Ada Data</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="id_pengemudi" class="col-form-label">Pengemudi</label> <br>
                                                                    <select id="id_pengemudi" name="id_pengemudi" class="form-select">
                                                                        @php
                                                                            $idDriverTerpilih = $m->id_driver;
                                                                        @endphp
                                                                        @forelse ($driver as $d)
                                                                            @if ($d->id_driver == $idDriverTerpilih)
                                                                            <option value="{{$idDriverTerpilih}}" selected>{{$d->nama}}</option>
                                                                            @else
                                                                            <option value="{{$d->id_driver}}">{{$d->nama}}</option>
                                                                            @endif
                                                                        @empty
                                                                        <option value="">Tidak Ada Data</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="no_polisi" class="col-form-label">No Polisi</label>
                                                                    <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="{{$m->no_polisi}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="merk_mobil" class="col-form-label">Merk Mobil</label>
                                                                    <input type="text" class="form-control" id="merk_mobil" name="merk_mobil" value="{{$m->merk_mobil}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="warna" class="col-form-label">Warna Mobil</label>
                                                                    <input type="text" class="form-control" id="warna" name="warna" value="{{$m->warna_mobil}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="kapasitas" class="col-form-label">Jumlah Kursi</label>
                                                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="{{$m->jumlah_kursi}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="foto" class="col-form-label">Foto Mobil  <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                                                    <input type="file" class="form-control" id="foto" name="foto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="fasilitas" class="col-form-label">Fasilitas Mobil</label>
                                                                    <textarea class="form-control" id="fasilitas" name="fasilitas" row="4">{{$m->fasilitas}}</textarea>
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
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">Tidak ada data</td>
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

<div class="modal fade" id="input-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah {{$title}}</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('mobil.tambah')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_perusahaan" class="col-form-label">Nama Perusahaan</label>
                                <select id="id_perusahaan" name="id_perusahaan" class="form-select">
                                    <option selected disabled>Pilih Nama Perusahaan</option>
                                    @forelse ($perusahaan as $p)
                                    <option value="{{$p->id_perusahaan}}">{{$p->nama_perusahaan}}</option>
                                    @empty
                                    <option value="">Tidak Ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_pengemudi" class="col-form-label">Pengemudi</label>
                                <select id="id_pengemudi" name="id_pengemudi" class="form-select">
                                    <option selected disabled>Pilih Pengemudi</option>
                                    @forelse ($driver as $d)
                                    <option value="{{$d->id_driver}}">{{$d->nama}}</option>
                                    @empty
                                    <option value="">Tidak Ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_polisi" class="col-form-label">No Polisi</label>
                                <input type="text" class="form-control" id="no_polisi" name="no_polisi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="merk_mobil" class="col-form-label">Merk Mobil</label>
                                <input type="text" class="form-control" id="merk_mobil" name="merk_mobil">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="warna" class="col-form-label">Warna Mobil</label>
                                <input type="text" class="form-control" id="warna" name="warna">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kapasitas" class="col-form-label">Jumlah Kursi</label>
                                <input type="number" class="form-control" id="kapasitas" name="kapasitas">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="foto" class="col-form-label">Foto Mobil  <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fasilitas" class="col-form-label">Fasilitas Mobil</label>
                                <textarea class="form-control" id="fasilitas" name="fasilitas" row="4"></textarea>
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
                    url: "{{url('/data-mobil/hapus')}}"+"/"+id,
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