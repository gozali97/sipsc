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
                            <li class="breadcrumb-item"><a href="/anggota">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pd-20">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#input-modal"><i
                        class="icon-copy fa fa-plus" aria-hidden="true"
                        style="margin-right: 5px"></i></i>Tambah</button>
                <div class="p-4">
                    <table id="datatable" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Tahun terbit</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($data as $p)
                            <tr>
                                <td class="table-plus">{{ $no++ }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->tahun_terbit }}</td>
                                <td>@php
                                    if($p->status == 1){
                                    $status = "Dipinjam";
                                    }else{
                                    $status = "Dikembalikan";
                                    }
                                    @endphp
                                    {{ $status }}
                                </td>
                                <td><img src="{{ url('assets/img/'.$p->gambar) }}" style="width:80px; height:80px;"
                                        alt=""></td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button class="btn btn-outline-info" data-toggle="modal"
                                            data-target="#bd-example-modal-lg{{ $p->no_pinjam }}"><i
                                                class="icon-copy fa fa-info-circle" aria-hidden="true"></i></button>
                                        <button class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#confirmModal{{ $p->no_pinjam }}">
                                            <i class="icon-copy fa fa-edit" aria-hidden="true"
                                                style="margin-right: 5px"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Info -->
                            <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg{{ $p->no_pinjam }}"
                                tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{ $p->no_pinjam }}"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="bd-example-modal-lg{{ $p->no_pinjam }}">Detail
                                                Pustaka</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                        </div>
                                        <form id="bd-example-modal-lg{{ $p->no_pinjam }}"
                                            action="{{ route('pinjam.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img src="{{ url('/assets/img/'.$p->gambar) }}"
                                                            style="width: 362px;height: 400px;" alt="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>{{ $p->judul }}</h5>
                                                        <p>{{ $p->deskripsi }}</p>
                                                        <p class="font-weight-bold">Tahun Terbit: </p>
                                                        <p class="">{{ $p->tahun_terbit }}</p>
                                                        <p class="font-weight-bold">ISBN</p>
                                                        <p>{{ $p->isbn }}</p>
                                                        <p class="font-weight-bold">Status</p>
                                                        <p>@php
                                                            if($p->status == 1){
                                                            $status = "Dipinjam";
                                                            }else{
                                                            $status = "Dikembalikan";
                                                            }
                                                            @endphp
                                                            {{ $status }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi -->
                            <div class="modal fade bs-example-modal-lg" id="confirmModal{{ $p->no_pinjam }}"
                                tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{ $p->no_pinjam }}"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="confirmModal{{ $p->no_pinjam }}">Konfirmasi
                                                Pengembalian</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                        </div>
                                        <form id="confirmModal{{ $p->no_pinjam }}"
                                            action="{{ route('listpinjam.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img src="{{ url('/assets/img/'.$p->gambar) }}"
                                                            style="width: 362px;height: 400px;" alt="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="no_pinjam"
                                                            value="{{ $p->no_pinjam }}">
                                                        <input type="hidden" name="id_user" value="{{ $p->id_user }}">
                                                        <input type="hidden" name="id_pustaka"
                                                            value="{{ $p->id_pustaka }}">
                                                        <h5>{{ $p->judul }}</h5>
                                                        <p>{{ $p->deskripsi }}</p>
                                                        <p class="font-weight-bold">Tahun Terbit: </p>
                                                        <p class="">{{ $p->tahun_terbit }}</p>
                                                        <p class="font-weight-bold">ISBN</p>
                                                        <p>{{ $p->isbn }}</p>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Simple Datatable End -->

        <div class="footer-wrap pd-20 mb-20 card-box">
            SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
        </div>
    </div>
</div>

<!-- Modal insert -->
<div class="modal fade bs-example-modal-lg" id="input-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Pinjaman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('listpinjam.insert') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group custom">
                        <select name="id_user" class="form-control form-control-lg" placeholder="Nama Anggota">
                            <option value="">-- Nama Anggota --</option>
                            @foreach ($anggota as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group custom">
                        <select name="pustaka" class="form-control form-control-lg" placeholder="Nama Pustaka">
                            <option value="">-- Judul Pustaka --</option>
                            @foreach ($pustaka as $buku)
                            <option value="{{ $buku->id_pustaka }}">{{ $buku->judul }} - {{ $buku->jumlah }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });

    $('select[name="pustaka"]').change(function() {
        var imgSrc = $('option:selected', this).data('img');
            if (imgSrc) {
                $('#buku-image').html('<img src="{{ url('/assets/img') }}/'+imgSrc+'" alt="gambar pustaka" width="200px">');
            } else {
                $('#buku-image').empty();
            }
    });
</script>
@endsection
