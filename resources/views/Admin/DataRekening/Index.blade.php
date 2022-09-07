@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <h3 class="card-title">{{$title}}</h3>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#input-modal">Tambah Rekening</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">No Rekening</th>
                                <th class="wd-20p border-bottom-0">Nama Pemilik</th>
                                <th class="wd-15p border-bottom-0">Nama Bank</th>
                                <th class="wd-25p border-bottom-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekening as $r)
                            <tr>
                                <td>{{$r->no_rekening}}</td>
                                <td>{{$r->nama_pemilik}}</td>
                                <td>{{$r->nama_bank}}</td>
                                <td>
                                    <div class="btn-group mt-2 mb-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                Opsi <span class="caret"></span>
                                            </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#edit-modal-{{$r->id}}">Edit</a></li>
                                            <li><a href="#" onclick="hapusModal('{{$r->id}}')">Hapus</a></li>
                                        </ul>
                                    </div>

                                    <div class="modal fade" id="edit-modal-{{$r->id}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Edit Rekening Pembayaran</h6>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('rekening.edit', $r->id)}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="no_rek" class="col-form-label">No Rekening</label>
                                                                    <input type="text" class="form-control" id="no_rek" name="no_rek" value="{{$r->no_rekening}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="pimpinan" class="col-form-label">Nama Pemilik</label>
                                                                    <input type="text" class="form-control" id="pimpinan" name="pimpinan" value="{{$r->nama_pemilik}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="nama_bank" class="col-form-label">Nama Bank</label> <br>
                                                                    <select id="nama_bank" name="nama_bank" class="form-select">
                                                                        @php
                                                                            $listBank = ['BRI', 'BCA', 'Mandiri', 'BNI', 'Bank Permata', 'CIMB Niaga', 'BTPN'];
                                                                        @endphp
                                                                        @foreach ($listBank as $bank)
                                                                            @if ($bank == $r->nama_bank)
                                                                            <option value="{{$bank}}" selected>{{$bank}}</option>
                                                                            @else
                                                                            <option value="{{$bank}}">{{$bank}}</option>
                                                                            @endif
                                                                        @endforeach
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

<!-- Inout modal -->
<div class="modal fade" id="input-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Rekening Pembayaran</h6>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{route('rekening.tambah', $perusahaan->id_perusahaan)}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_rek" class="col-form-label">No Rekening</label>
                                <input type="text" class="form-control" id="no_rek" name="no_rek">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pimpinan" class="col-form-label">Nama Pemilik</label>
                                <input type="text" class="form-control" id="pimpinan" name="pimpinan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nama_bank" class="col-form-label">Nama Bank</label>
                                <select id="nama_bank" name="nama_bank" class="form-select">
                                    <option selected disabled>Pilih Bank</option>
                                    @php
                                        $listBank = ['BRI', 'BCA', 'Mandiri', 'BNI', 'Bank Permata', 'CIMB Niaga', 'BTPN'];
                                    @endphp
                                    @foreach ($listBank as $bank)
                                        <option value="{{$bank}}">{{$bank}}</option>
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
                    url: "{{url('/data-perusahaan/rekening/hapus/')}}"+"/"+id,
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