@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah
                        Pengguna</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Nama Pengguna</th>
                                <th class="wd-15p border-bottom-0">NIK</th>
                                <th class="wd-20p border-bottom-0">Tanggal Lahir</th>
                                <th class="wd-15p border-bottom-0">Hak Akses</th>
                                <th class="wd-15p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Foto Pengguna</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengguna as $p)
                            <tr>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->nik}}</td>
                                <td>{{$p->tgl_lahir}}</td>
                                <td>{{$p->role}}</td>
                                <td>
                                    @if ($p->status_aktif == 1)
                                        Aktif
                                    @else
                                        Non-Aktif
                                    @endif
                                </td>
                                <td>
                                    @if ($p->foto != null)
                                    <a href="{{asset('foto/'.$p->foto)}}" target="_blank"><img
                                            src="{{asset('foto/'.$p->foto)}}" alt="Gambar {{$p->nama}}"
                                            style="width: 100px"></a>
                                    @else
                                    Gambar Tidak Ada
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group mt-2 mb-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            Opsi <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)"
                                                    onclick="resetPassModal('{{$p->id}}')">Reset Password</a></li>
                                            <li><a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#edit-modal-{{$p->id}}">Edit</a></li>
                                            <li><a href="javascript:void(0)"
                                                    onclick="hapusModal('{{$p->id}}')">
                                                    @if ($p->status_aktif == 1)
                                                        Non Aktifkan
                                                    @else
                                                        Aktifkan
                                                    @endif
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$p->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit Data Pengguna: {{$p->nama}}</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('pengguna.edit')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_user" value="{{$p->id}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="username" class="col-form-label">Username (Tidak boleh ada spasi)</label>
                                                                    <input type="text" class="form-control" id="username" name="username" value="{{$p->username}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_lengkap" class="col-form-label">Nama Lengkap</label>
                                                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{$p->nama}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="col-form-label">Email</label>
                                                                    <input type="email" class="form-control" id="email" name="email" value="{{$p->email}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="no_telp" class="col-form-label">No Telpon</label>
                                                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{$p->no_telp}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="nik" class="col-form-label">NIK</label>
                                                                    <input type="text" class="form-control" id="nik" name="nik" value="{{$p->nik}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tgl_lahir" class="col-form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{$p->tgl_lahir}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="umur" class="col-form-label">Umur</label>
                                                                    <input type="number" class="form-control" id="umur" name="umur" value="{{$p->umur}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="agama" class="col-form-label">Agama</label> <br>
                                                                    <select class="form-select" name="agama">
                                                                        @php
                                                                            $agamaTerpilih = $p->agama;
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
                                                                    <label for="foto" class="col-form-label">Foto Profil (Opsional)  <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                                                    <input type="file" class="form-control" id="foto" name="foto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="alamat" class="col-form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{$p->alamat}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="link_alamat" class="col-form-label">Link Alamat (Opsional)</label>
                                                                    <input type="text" class="form-control" id="link_alamat" name="link_alamat" value="{{$p->url_alamat}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="akses" class="col-form-label">Role Akses</label>
                                                                    <input type="text" class="form-control" name="akses" value="{{$p->role}}" readonly>
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
                                <td colspan="6">Tidak ada data</td>
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
                <h6 class="modal-title">Tambah Data Pengguna</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('pengguna.tambah')}}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                <b>Perhatian!</b> Password Di Generate Oleh Sistem <b>(12345678)</b>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="alert alert-warning" role="alert">
                                <b>Perhatian!</b> Role Pengemudi <b>Wajib Melengkapi Data</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="col-form-label">Username (Tidak boleh ada spasi)</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="col-form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telp" class="col-form-label">No Telpon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nik" class="col-form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tgl_lahir" class="col-form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="umur" class="col-form-label">Umur</label>
                                <input type="number" class="form-control" id="umur" name="umur">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="agama" class="col-form-label">Agama</label>
                                <select class="form-select" name="agama">
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
                                <label for="foto" class="col-form-label">Foto Profil (Opsional)  <span class="text-muted" style="font-size: 10px">Maksimal 2MB</span></label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="col-form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
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
                                <label for="akses" class="col-form-label">Role Akses</label>
                                <select class="form-select" name="akses" id="akses">
                                    <option selected disabled>Pilih Akses</option>
                                    <option value="Penumpang">Penumpang</option>
                                    <option value="Pengemudi">Pengemudi</option>
                                    <option value="Agent">Agent Travel</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="perusahaan-select" style="display: none">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="perusahaan" class="col-form-label">Pilih Perusahaan</label>
                                <select class="form-select" name="perusahaan" id="perusahaan">
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
            title: 'Ubah Status?',
            text: 'Yakin ingin ubah status pengguna ini?',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('/data-pengguna/hapus')}}"+"/"+id,
                    success: function(json){
                        if(json.status == 200){
                            Swal.fire('Berhasil Ubah Status!', '', 'success');
                            location.reload();
                        }
                    },
                    error: function(err){
                        if(json.status == 500){
                            Swal.fire('Gagal Ubah Status!', '', 'warning');
                            location.reload();
                        }
                    }
                });
            }
        })
    }

    function resetPassModal(id){
        Swal.fire({
            icon: 'question',
            title: 'Reset Password?',
            text: 'Password Akan Di Reset Secara Default, Menjadi 12345678?',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('/data-pengguna/resetpass')}}"+"/"+id,
                    success: function(json){
                        if(json.status == 200){
                            Swal.fire('Berhasil Reset Password!', '', 'success');
                            location.reload();
                        }
                    },
                    error: function(err){
                        if(json.status == 500){
                            Swal.fire('Gagal Reset Password!', '', 'warning');
                            location.reload();
                        }
                    }
                });
            }
        })
    }

    $("#akses").change(function(){
        let akses = $("#akses").val();

        if(akses == 'Pengemudi' || akses == 'Agent'){
            $("#perusahaan-select").css("display", "block");
        }else{
            $("#perusahaan-select").css("display", "none");
        }
    });
</script>
@endpush