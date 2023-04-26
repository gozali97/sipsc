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
                <a href="/list" type="button" class="btn btn-success"><i
                        class="icon-copy fa fa-plus" aria-hidden="true"
                        style="margin-right: 5px"></i></i>Tambah</a>
                <div class="p-4">
                    <table id="datatable" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->tahun_terbit }}</td>
                                <td>
                                    <span class="badge {{$p->sts == "Proses" ? 'badge-warning' : ($p->sts == "Dipinjam" ? 'badge-success' : 'badge-danger') }}">{{ $p->sts }}</span>
                                </td>
                                <td><img src="{{ url('assets/img/'.$p->gambar) }}"
                                        style="width:80px; height:80px;" alt=""></td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#bd-example-modal-lg{{ $p->no_pinjam }}"><i class="icon-copy fa fa-edit"
                                            aria-hidden="true" style="margin-right: 5px"></i>Detail</button>
                                </td>
                            </tr>
                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg{{ $p->no_pinjam }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{ $p->no_pinjam }}" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="bd-example-modal-lg{{ $p->no_pinjam }}">Detail Pustaka</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form id="bd-example-modal-lg{{ $p->no_pinjam }}" action="{{ route('pinjam.store') }}" method="POST">
                                                @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img src="{{ url('/assets/img/'.$p->gambar) }}" style="width: 362px;height: 400px;" alt="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>{{ $p->judul }}</h5>
                                                        <p>{{ $p->deskripsi }}</p>
                                                        <p class="font-weight-bold">Tahun Terbit: </p>
                                                        <p class="">{{ $p->tahun_terbit }}</p>
                                                        <p class="font-weight-bold">ISBN</p>
                                                        <p>{{ $p->isbn }}</p>
                                                        <p class="font-weight-bold">Status</p>
                                                        <p>
                                                            {{ $p->sts }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Pengarang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group custom">
                        <input type="text" name="nama" class="form-control form-control-lg" placeholder="Nama Anggota">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="Email">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-email"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="no_hp" class="form-control form-control-lg" placeholder="No Handphone">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-smartphone-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="alamat" class="form-control form-control-lg" placeholder="Alamat">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-building-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="file" name="gambar" class="form-control-file form-control height-auto">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-image"></i></span>
                        </div>
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
</script>
@endsection
