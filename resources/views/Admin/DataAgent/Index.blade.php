@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah Agent</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Nama Agent</th>
                                <th class="wd-15p border-bottom-0">NIK</th>
                                <th class="wd-20p border-bottom-0">Tanggal Lahir</th>
                                <th class="wd-15p border-bottom-0">Umur</th>
                                <th class="wd-10p border-bottom-0">Perusahaan</th>
                                <th class="wd-25p border-bottom-0">Foto Agent</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agent as $a)
                            <tr>
                                <td>{{$a->nama}}</td>
                                <td>{{$a->nik}}</td>
                                <td>{{$a->tgl_lahir}}</td>
                                <td>{{$a->umur}}</td>
                                <td>{{$a->nama_perusahaan}}</td>
                                <td>
                                    @if ($a->foto != null)
                                        <a href="{{asset('foto/'.$a->foto)}}" target="_blank"><img src="{{asset('foto/'.$a->foto)}}" alt="Gambar {{$a->nama}}" style="width: 100px"></a>
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
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{$a->id_agent}}">Edit</a></li>
                                            {{-- <li><a href="#" onclick="hapusModal('{{$a->id}}')">Hapus</a></li> --}}
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$a->id_agent}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit Data Agent</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('agent.edit')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_user" value="{{$a->id}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="username" class="col-form-label">Username (Tidak boleh ada spasi)</label>
                                                                    <input type="text" class="form-control" id="username" name="username" value="{{$a->username}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_lengkap" class="col-form-label">Nama Lengkap</label>
                                                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{$a->nama}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="col-form-label">Email</label>
                                                                    <input type="email" class="form-control" id="email" name="email" value="{{$a->email}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="no_telp" class="col-form-label">No Telpon</label>
                                                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{$a->no_telp}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="nik" class="col-form-label">NIK</label>
                                                                    <input type="text" class="form-control" id="nik" name="nik" value="{{$a->nik}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tgl_lahir" class="col-form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{$a->tgl_lahir}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="umur" class="col-form-label">Umur</label>
                                                                    <input type="number" class="form-control" id="umur" name="umur" value="{{$a->umur}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="agama" class="col-form-label">Agama</label> <br>
                                                                    <select class="form-select" name="agama">
                                                                        @php
                                                                            $agamaTerpilih = $a->agama;
                                                                            $listAgama = ['Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                                                                        @endphp
    
                                                                        @foreach ($listAgama as $agama)
                                                                            @if ($agama == $agamaTerpilih)
                                                                            <option value="{{$agamaTerpilih}}" selected>{{$agamaTerpilih}}</option>
                                                                            @else
                                                                            <option value="{{$agama}}">{{$agama}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="foto" class="col-form-label">Foto Profil (Opsional) <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                                                    <input type="file" class="form-control" id="foto" name="foto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="alamat" class="col-form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{$a->alamat}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="link_alamat" class="col-form-label">Link Alamat (Opsional)</label>
                                                                    <input type="text" class="form-control" id="link_alamat" name="link_alamat" value="{{$a->url_alamat}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="perusahaan" class="col-form-label">Pilih Perusahaan</label> <br>
                                                                    <select class="form-select" name="perusahaan">
                                                                        @php
                                                                            $perusahaanTerpilih = $a->id_perusahaan;
                                                                        @endphp
                                                                        @foreach ($perusahaan as $p)
                                                                            @if ($p->id_perusahaan == $perusahaanTerpilih)
                                                                            <option value="{{$perusahaanTerpilih}}" selected>{{$a->nama_perusahaan}}</option>
                                                                            @else
                                                                            <option value="{{$p->id_perusahaan}}">{{$p->nama_perusahaan}}</option>
                                                                            @endif
                                                                        @endforeach
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

<!-- Inout modal -->
<div class="modal fade" id="input-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Data Agent</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('agent.tambah')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="col-form-label">Username (Tidak boleh ada spasi)</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="col-form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telp" class="col-form-label">No Telpon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nik" class="col-form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_lahir" class="col-form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="umur" class="col-form-label">Umur</label>
                                <input type="number" class="form-control" id="umur" name="umur" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="agama" class="col-form-label">Agama</label>
                                <select class="form-select" name="agama" required>
                                    <option selected disabled>Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Protestan">Protestan</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="foto" class="col-form-label">Foto Profil (Opsional) <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="col-form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="link_alamat" class="col-form-label">Link Alamat (Opsional)</label>
                                <input type="text" class="form-control" id="link_alamat" name="link_alamat">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="perusahaan" class="col-form-label">Pilih Perusahaan</label>
                                <select class="form-select" name="perusahaan" id="perusahaan" required>
                                    <option selected disabled>Pilih Perusahaan</option>
                                    @forelse ($perusahaan as $p)
                                    <option value="{{$p->id_perusahaan}}">{{$p->nama_perusahaan}}</option>
                                    @empty
                                    <option>Belum Ada Perusahaan Yang Terdaftar</option>
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
                    url: "{{url('/data-agent/hapus')}}"+"/"+id,
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