@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script>
    $(document).ready(function(){
            setTimeout(function(){
                $(".alert").alert('close');
            }, 5000);
        });
</script>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script>
    $(document).ready(function(){
            setTimeout(function(){
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
    $(document).ready(function(){
                setTimeout(function(){
                    $(".alert").alert('close');
                }, 5000);
            });
</script>
@endif

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Peminjaman</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/listpinjam">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Peminjaman</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        @foreach ($data as $d)
        <div class="card mb-3">
            <div class="row">
                <div class="col-sm-3">
                    <img class="card-img-top" src="{{ url('assets/img/'.$d->gambar) }}" alt="Card image cap">
                </div>
                <div class="col-sm-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ $d->judul }}</h5>
                        <p class="card-text">{{ $d->deskripsi }}</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="font-weight-bold">Tahun Terbit: </p>
                                <p class="">{{ $d->tahun_terbit }}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="font-weight-bold">ISBN</p>
                                <p>{{ $d->isbn }}</p>
                            </div>
                        </div>
                        <p class="font-weight-bold">Nama Peminjam : {{ $d->nama }} <br> Kelas : {{ $d->kelas }}</p>
                        <button type="button" data-toggle="modal" data-target="#confirmModal{{ $d->no_det_pinjaman }}"
                            class="btn btn-primary">Kembalikan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi -->
        <div class="modal fade bs-example-modal-lg" id="confirmModal{{ $d->no_det_pinjaman }}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel{{ $d->no_pinjam }}" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmModal{{ $d->no_det_pinjaman }}">Konfirmasi
                            Pengembalian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form id="confirmModal{{ $d->no_det_pinjaman }}" action="{{ route('listpinjam.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ url('/assets/img/'.$d->gambar) }}" style="height: 400px;" alt="">
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="pinjam" value="{{ $d->no_det_pinjaman }}">
                                    <input type="hidden" name="id_pustaka" value="{{ $d->id_pustaka }}">
                                    <p class="font-weight-bold">Kondisi</p>
                                    <div class="input-group custom">
                                        <select name="kondisi" class="form-control form-control-lg"
                                            placeholder="Nama Anggota">
                                            <option value="">-- Kondisi --</option>
                                            @foreach ($kondisi as $k)
                                            <option value="{{ $k->kd_kondisi }}">{{
                                                $k->jenis_kondisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $date = \Carbon\Carbon::now();

                                        $peminjaman = \App\Models\DetailPeminjaman::query()
                                        ->where('no_det_pinjaman',$d->no_det_pinjaman)
                                        ->first();

                                        $tgl_pinjam = $peminjaman->tgl_pinjam;

                                        $datetime1 = new \DateTime($tgl_pinjam);
                                        $datetime2 = $date;
                                        $interval = $datetime1->diff($datetime2);
                                        $jumlah_hari_terlambat = $interval->days - 16;
                                        if ($jumlah_hari_terlambat < 0) {
                                            $jumlah_hari_terlambat = 0;
                                        }
                                        $nominal_denda = $jumlah_hari_terlambat * 2000;
                                    @endphp
                                    <p class="font-weight-bold">Denda Keterlambatan :<br> Rp. {{ number_format($nominal_denda, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endforeach

        <a href="/listpinjam" class="btn btn-danger mb-30">Kembali</a>
    </div>
</div>

@endsection
