@php
    $pesanan = DB::table('tblpemesanan')
            ->join('destinasi', 'destinasi.id', '=', 'tblpemesanan.destinasi_id')
            ->join('tblpenjemputan', 'tblpenjemputan.id', '=', 'tblpemesanan.penjemputan_id')
            ->join('tbluser', 'tbluser.id', '=', 'tblpemesanan.user_id')
            ->join('tblmobil', 'tblmobil.id_mobil', '=', 'tblpemesanan.mobil_id')
            ->join('tblperusahaan', 'tblperusahaan.id_perusahaan', '=', 'tblmobil.perusahaan_id')
            ->where('status_bayar', 'Pending')->count();
@endphp
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{route('dashboard')}}">
                <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo"
                    alt="logo">
                <img src="{{ asset('assets/images/brand/logo-2.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Dashboard</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{route('dashboard')}}"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                </li>
                <li class="sub-category">
                    <h3>Main Menu</h3>
                </li>
                @if (Auth::user()->role == 'Admin')
                <li>
                    <a class="side-menu__item has-link" href="{{route('pengguna')}}"><i
                            class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Data Pengguna</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('agent')}}"><i
                            class="side-menu__icon fe fe-user-check"></i><span class="side-menu__label">Data Agen Travel</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('pengemudi')}}"><i
                            class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Data Pengemudi</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('penumpang')}}"><i
                            class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Data Penumpang</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('mobil')}}"><i
                            class="side-menu__icon fe fe-truck"></i><span class="side-menu__label">Data Mobil Travel</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('penjemputan')}}"><i
                            class="side-menu__icon fe fe-map-pin"></i><span class="side-menu__label">Data Penjemputan</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('destinasi')}}"><i
                            class="side-menu__icon fe fe-map"></i><span class="side-menu__label">Data Destinasi</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('perusahaan')}}"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Data Perusahaan</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('pembayaran')}}"><i
                            class="side-menu__icon fe fe-dollar-sign"></i><span class="side-menu__label">Konfirmasi Pembayaran</span><span class="badge bg-green br-5 side-badge blink-text pb-1">{{$pesanan}}</span></a>
                </li>
                {{-- <li>
                    <a class="side-menu__item has-link" href="#"><i
                            class="side-menu__icon fe fe-message-circle"></i><span class="side-menu__label">Kelola Rating / Masukan</span></a>
                </li>  --}}
                @elseif(Auth::user()->role == 'Agent')
                <li>
                    <a class="side-menu__item has-link" href="{{route('pengemudi')}}"><i
                            class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Data Pengemudi</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('mobil')}}"><i
                            class="side-menu__icon fe fe-truck"></i><span class="side-menu__label">Data Mobil Travel</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('penjemputan')}}"><i
                            class="side-menu__icon fe fe-map-pin"></i><span class="side-menu__label">Data Penjemputan</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('destinasi')}}"><i
                            class="side-menu__icon fe fe-map"></i><span class="side-menu__label">Data Destinasi</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('pembayaran')}}"><i
                            class="side-menu__icon fe fe-dollar-sign"></i><span class="side-menu__label">Konfirmasi Pembayaran</span><span class="badge bg-green br-5 side-badge blink-text pb-1">{{$pesanan}}</span></a>
                </li>
                @elseif(Auth::user()->role == 'Pengemudi')
                {{-- <li>
                    <a class="side-menu__item has-link" href="{{route('pengemudi.cekjadwal')}}"><i
                            class="side-menu__icon fe fe-calendar"></i><span class="side-menu__label">Cek Jadwal</span></a>
                </li> --}}
                <li>
                    <a class="side-menu__item has-link" href="{{route('pengemudi.penjemputan')}}"><i
                            class="side-menu__icon fe fe-map"></i><span class="side-menu__label">Cek Penjemputan</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('pengemudi.riwayatpenjemputan')}}"><i
                            class="side-menu__icon fe fe-rotate-ccw"></i><span class="side-menu__label">Riwayat Penjemputan</span></a>
                </li>
                @elseif(Auth::user()->role == 'Penumpang')
                <li>
                    <a class="side-menu__item has-link" href="{{route('penumpang.pesan')}}"><i
                            class="side-menu__icon fe fe-shopping-bag"></i><span class="side-menu__label">Pesan Travel</span></a>
                </li>
                <li>
                    <a class="side-menu__item has-link" href="{{route('penumpang.pesanan')}}"><i
                            class="side-menu__icon fe fe-package"></i><span class="side-menu__label">Data Pesanan</span></a>
                </li>
                @endif
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>