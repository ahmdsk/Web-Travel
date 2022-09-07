<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Web Travel Collaborative Filtering">
    <meta name="author" content="Ahmdgans24">
    <meta name="keywords" content="web travel, travel, website travel, collaborative filtering">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/favicon.ico')}}" />

    <!-- TITLE -->
    <title>Daftar Sekarang - Web Travel</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/css/transparent-style.c') }}ss" rel="stylesheet">
    <link href="{{asset('assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{asset('assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{asset('assets/colors/color1.css')}}" />

</head>

<body class="app sidebar-mini ltr login-img">

    <!-- BACKGROUND-IMAGE -->
    <div class="">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="{{asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" action="{{route('register')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <span class="login100-form-title"> Daftar Akun </span>
                            <div class="alert alert-warning" role="alert">
                                Perhatian! Silahkan Lengkapi Form Jika Anda Mendaftar Sebagai Pengemudi.
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Username (Tidak Boleh Spasi)</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-account" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="text"
                                            placeholder="Username" name="username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Lengkap</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-account-card-details" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="text"
                                            placeholder="Nama Lengkap" name="nama_lengkap">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-email" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="email"
                                            placeholder="Email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="zmdi zmdi-eye" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="password"
                                            placeholder="Password" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No Telpon</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-whatsapp" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="text"
                                            placeholder="No Telpon" name="no_telp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Lahir</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-calendar" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="date"
                                            placeholder="Tanggal Lahir" name="tgl_lahir">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>NIK</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-account-card-details" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="text"
                                            placeholder="NIK" name="nik">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Umur (Opsional)</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-cake" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" type="number"
                                            placeholder="Umur" name="umur">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Agama</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-atom" aria-hidden="true"></i>
                                        </a>
                                        <select class="form-select input100 border-start-0 ms-0" name="agama">
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
                                    <label>Foto Profil (Opsional)</label>
                                    <input class="form-control form-control-lg" name="foto" type="file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Alamat</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-map" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" name="alamat" type="text"
                                            placeholder="Alamat">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Link Alamat (Opsional)</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-link" aria-hidden="true"></i>
                                        </a>
                                        <input class="input100 border-start-0 ms-0 form-control" name="link_alamat" type="text"
                                            placeholder="Link Alamat (Google Maps)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Daftar Sebagai</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-account-settings-variant" aria-hidden="true"></i>
                                        </a>
                                        <select class="form-select input100 border-start-0 ms-0" name="akses" id="role-akses">
                                            <option selected disabled>Pilih Role Akses</option>
                                            <option value="Penumpang">Penumpang</option>
                                            <option value="Pengemudi">Pengemudi</option>
                                            <option value="Agent">Agent Travel</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="fitur-agent-driver" style="display: none">
                                <div class="col-12">
                                    <label>Perusahaan Travel</label>
                                    <div class="wrap-input100 validate-input input-group">
                                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                            <i class="mdi mdi-truck" aria-hidden="true"></i>
                                        </a>
                                        <select class="form-select input100 border-start-0 ms-0" name="perusahaan">
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
                            <label class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Terima Persyaratan Dan Persetujuan Aplikasi</span>
                            </label>
                            <div class="container-login100-form-btn">
                                <button type="submit" class="login100-form-btn btn btn-primary">
                                    Daftar
                                </button>
                            </div>
                            <div class="text-center pt-3">
                                <p class="text-dark mb-0">Belum Memiliki Akun?<a href="{{route('login')}}"
                                        class="text-primary ms-1">Masuk Disini</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- END PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- SHOW PASSWORD JS -->
    <script src="{{ asset('assets/js/show-password.min.js') }}"></script>

    <!-- GENERATE OTP JS -->
    <script src="{{ asset('assets/js/generate-otp.js') }}"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>

    <!-- Color Theme js -->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- SWEET-ALERT JS -->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>

    @if ($message = Session::get('success'))
    <script>
        swal("Berhasil!", "{{ $message }}", "success");
    </script>
    @endif

    @if ($message = Session::get('info'))
    <script>
        swal("Perhatian!", "{{ $message }}", "info");
    </script>
    @endif

    @if ($message = Session::get('warning'))
    <script>
        swal("Gagal!", "{{ $message }}", "warning");
    </script>
    @endif

    <script>
        $("#role-akses").change(function(e){
            let akses = $("#role-akses").val();

            if(akses == 'Agent' || akses == 'Pengemudi'){
                $("#fitur-agent-driver").css("display", "block");
            }else{
                $("#fitur-agent-driver").css("display", "none");
            }
        });
    </script>
</body>

</html>