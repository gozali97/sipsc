@extends('layouts.app')

@section('content')
<div class="pd-ltr-20">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ url('assets/vendors/images/banner-img.png') }}" alt="">
            </div>
            <div class="col-md-8">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    Welcome back <div class="weight-600 font-30 text-blue">{{ Auth::user()->name }}</div>
                </h4>
                <p class="font-18 max-width-600">SMK Negeri 1 Cangkringan merupakan salah satu sekolah negeri yang
                    terletak di Sintokan, Wukirsari, Cangkringan, Sleman, Yogyakarta, dengan jumlah siswa 1.250 yang
                    terbagi menjadi 4 kejuruan yaitu Agribisnis Ternak Ruminansia, Agribisnis Pengolahan Hasil
                    Pertanian, Teknik Kendaraan Ringan (Otomotif), Analisis Pengujian Laboratorium.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <img src="{{ url('/assets/img/buku.png') }}" alt="">
                    </div>
                    <div class="widget-data">
                        @php
                        $bukuCount = \App\Models\Pustaka::count();
                        @endphp
                        <div class="h4 mb-0">{{ $bukuCount }}</div>
                        <div class="weight-600 font-14">Buku</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <img src="{{ url('/assets/img/book-out.png') }}"  alt="">
                    </div>
                    <div class="widget-data">
                        @php
                        $pinjamCount = \App\Models\Peminjaman::count();
                        @endphp
                        <div class="h4 mb-0">{{ $pinjamCount }}</div>
                        <div class="weight-600 font-14">Pinjaman</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <img src="{{ url('/assets/img/book-in.png') }}" alt="">
                    </div>
                    <div class="widget-data">
                        @php
                        $kembaliCount = \App\Models\Pengembalian::count();
                        @endphp
                        <div class="h4 mb-0">{{ $kembaliCount }}</div>
                        <div class="weight-600 font-14">Pengembalian</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <img src="{{ url('/assets/img/user.png') }}" alt="">
                    </div>
                    <div class="widget-data">
                        @php
                        $anggotaCount = \App\Models\User::where('role_id', 3)->count();
                        @endphp
                        <div class="h4 mb-0">{{ $anggotaCount }}</div>
                        <div class="weight-600 font-14">Anggota</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
    </div>
</div>
@endsection
