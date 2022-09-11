@extends('layouts.Template')
@section('Konten')
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('pengguna.ubahprofile')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label class="mt-4" for="">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{$profile->nama}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="mt-4" for="">Email</label>
                            <input type="email" name="email" value="{{$profile->email}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="mt-4" for="">No Telpon</label>
                            <input type="text" name="no_telp" value="{{$profile->no_telp}}" class="form-control">
                        </div>
    
                        <div class="col-md-4">
                            <label class="mt-4" for="">Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir" value="{{$profile->tgl_lahir}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="mt-4" for="">Umur</label>
                            <input type="number" name="umur" value="{{$profile->umur}}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="mt-4" for="">NIK</label>
                            <input type="text" name="nik" value="{{$profile->nik}}" class="form-control">
                        </div>
    
                        <div class="col-md-12">
                            <label class="mt-4" for="">Agama</label>
                            <select name="agama" class="form-control">
                                @php
                                    $agamaTerpilih = $profile->agama;
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
    
                        <div class="col-md-6">
                            @if ($profile->foto != null)
                            <img src="{{asset('foto/'.$profile->foto)}}" alt="Foto {{$profile->nama}}" style="width: 130px; margin-top: 15px;"><br>
                            @endif
                            <label class="mt-4" for="">Foto Profil</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
    
                        <div class="col-md-6">
                            <label class="mt-4" for="">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="5">{{$profile->alamat}}</textarea>
                        </div>
    
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Ubah Profile</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection