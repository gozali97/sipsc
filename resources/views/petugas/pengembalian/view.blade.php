@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <div class="title">
                            <h4>Pengembalian</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation" class="row">
                            <div class="col-md-10">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/listpinjam">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Pengembalian</li>
                                </ol>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row">
                    @foreach ($data as $p)
                        <div class="col-md-6 p-4">
                            <center>
                                <img src="{{ url('/assets/img/' . $p->gambar) }}" style="width: 222px;height: 230px;"
                                    alt="">
                            </center>
                            <div class="p-4">
                                <h5 class="mt-2">{{ $p->judul }}</h5>
                                <p>{{ $p->deskripsi }}</p>
                                <p class="font-weight-bold">Tahun Terbit: </p>
                                <p class="">{{ $p->tahun_terbit }}</p>
                                <p class="font-weight-bold">ISBN</p>
                                <p>{{ $p->isbn }}</p>
                                <p class="font-weight-bold">Status</p>
                                <p>@php
                                    if ($p->status == 1) {
                                        $status = 'Dipinjam';
                                    } else {
                                        $status = 'Dikembalikan';
                                    }
                                @endphp
                                    {{ $status }}</p>
                                <p class="font-weight-bold">Tanggal Pinjam</p>
                                <p>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d-m-Y') }}
                                    Jam :
                                    {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('H:i') }}
                                    WIB</p>
                                <p class="font-weight-bold">Tanggal Dikembalikan</p>
                                <p>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d-m-Y') }}
                                    Jam :
                                    {{ \Carbon\Carbon::parse($p->tgl_kembali)->format('H:i') }}
                                    WIB</p>
                                <p class="font-weight-bold">Jumlah Keterlambatan</p>
                                <p>{{ $p->jml_terlambat }} Hari</p>
                                <p class="font-weight-bold">Denda</p>
                                <p>Rp. {{ number_format($p->nominal_denda, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <center>
                <a href="/listkembali" class="btn btn-danger mb-30">Kembali</a>
            </center>
        </div>
    </div>
@endsection
