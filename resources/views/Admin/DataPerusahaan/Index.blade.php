@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah Perusahaan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Nama Perusahaan</th>
                                <th class="wd-15p border-bottom-0">Pimpinan</th>
                                <th class="wd-20p border-bottom-0">No Telpon</th>
                                <th class="wd-15p border-bottom-0">Alamat Perusahaan</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($perusahaan as $p)
                            <tr>
                                <td>{{$p->nama_perusahaan}}</td>
                                <td>{{$p->pimpinan_perusahaan}}</td>
                                <td>{{$p->no_telpon_perusahaan}}</td>
                                <td>{{$p->alamat_perusahaan}}</td>
                                <td>
                                    <div class="btn-group mt-2 mb-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                Opsi <span class="caret"></span>
                                            </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{route('rekening', $p->id_perusahaan)}}">Atur Rekening</a></li>
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{$p->id_perusahaan}}">Edit</a></li>
                                            <li><a href="#" onclick="hapusModal('{{$p->id_perusahaan}}')">Hapus</a></li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$p->id_perusahaan}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit {{$title}}</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('perusahaan.edit')}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="id_perusahaan" value="{{$p->id_perusahaan}}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_perusahaan" class="col-form-label">Nama Perusahaan</label>
                                                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{$p->nama_perusahaan}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="pimpinan" class="col-form-label">Pimpinan</label>
                                                                    <input type="text" class="form-control" id="pimpinan" name="pimpinan" value="{{$p->pimpinan_perusahaan}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="no_telp" class="col-form-label">No Telpon</label>
                                                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{$p->no_telpon_perusahaan}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="alamat" class="col-form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{$p->alamat_perusahaan}}">
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
                <h6 class="modal-title">Tambah {{$title}}</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('perusahaan.tambah')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_perusahaan" class="col-form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pimpinan" class="col-form-label">Pimpinan</label>
                                <input type="text" class="form-control" id="pimpinan" name="pimpinan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telp" class="col-form-label">No Telpon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="col-form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
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
                    url: "{{url('/data-perusahaan/hapus')}}"+"/"+id,
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